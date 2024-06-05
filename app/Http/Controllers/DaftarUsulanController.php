<?php

namespace App\Http\Controllers;

use App\Models\Trx_usulan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DaftarUsulanController extends Controller
{
    public function index()
    {
        $usulan = $this->lihat_usulan();
        $dosen_id = DB::table("ref_dosen")->where("dosen_email_polines", Auth::user()->email)->first();
        $count_usulan = DB::table("trx_usulan_anggota_dosen")->where("dosen_id", $dosen_id->dosen_id)->count();
        return view('daftar-usulan.index', compact('usulan', 'count_usulan'));
    }
    public function lihat_usulan()
    {
        $dosen_id = DB::table("ref_dosen")->where("dosen_email_polines", Auth::user()->email)->first();
        $lihat_usulan_dosen = DB::table("trx_usulan_anggota_dosen")->where("dosen_id", $dosen_id->dosen_id)->get();

        $data = [];
        foreach ($lihat_usulan_dosen as $key => $value) {
            $judul_usulan = DB::table('trx_usulan')->where('usulan_id', $value->usulan_id)->first();
            $nama_skema  = DB::table('trx_skema')->where('trx_skema_id', $judul_usulan->trx_skema_id)->first();
            $id_ketua = DB::table("trx_usulan_anggota_dosen")->where("usulan_id", $value->usulan_id)->where("is_ketua", 1)->pluck('dosen_id');

            $data[$key] = [
                "usulan_id" =>  $value->usulan_id,
                "usulan_judul" => $judul_usulan->usulan_judul,
                "usulan_abstrak" => $judul_usulan->usulan_abstrak,
                "skema_id" => $judul_usulan->trx_skema_id,
                "nama_skema"   => $nama_skema->trx_skema_nama,
                "ketua" => DB::table('ref_dosen')->where('dosen_id', $id_ketua)->first(),
                "count_pendanaan" => DB::table('trx_usulan_dana')->where('usulan_id', $value->usulan_id)->count(),
                "pendanaan" => DB::table('trx_usulan_dana')->where('usulan_id', $value->usulan_id),
                "status_usulan" => DB::table('trx_usulan_status')
                    ->join('ref_status', 'trx_usulan_status.status_id', '=', 'ref_status.status_id')
                    ->where('usulan_id', $value->usulan_id)
                    ->get(['trx_usulan_status.status_id', 'status_nama', 'status_color']),
                "dosen_anggota" => DB::table('trx_usulan_anggota_dosen')
                    ->join('ref_dosen', 'trx_usulan_anggota_dosen.dosen_id', '=', 'ref_dosen.dosen_id')
                    ->where('is_ketua', 0)
                    ->where('usulan_id', $value->usulan_id)
                    ->get(['dosen_nama_lengkap', 'ref_dosen.dosen_id']),
                "mhs_anggota" => DB::table('trx_usulan_anggota_mhs')
                    ->join('ref_mahasiswa', 'trx_usulan_anggota_mhs.mhs_id', '=', 'ref_mahasiswa.mhs_id')
                    ->where('usulan_id', $value->usulan_id)
                    ->get(['mhs_nama', 'ref_mahasiswa.mhs_id']),
            ];
        }
        return $data;
    }
    public function step_0(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'abstrak' => 'required'
        ]);

        // Masuk ke tabel trx_usulan
        $insert_trx_usulan = DB::table('trx_usulan')->insertGetId([
            'usulan_judul'  => $request->judul,
            'usulan_abstrak' => $request->abstrak,
            'usulan_pendanaan' => null,
            'trx_skema_id' => $request->skema_id,
            'is_active' => 1,
            'is_submitted' => 0,
            'created_at' => now(),
        ]);
        $usulan_id = $insert_trx_usulan;

        // Masuk ke trx_usulan_anggota_dosen (ketua)
        DB::table('trx_usulan_anggota_dosen')->insert([
            'usulan_id' => $usulan_id,
            'dosen_id' => DB::table("ref_dosen")->where("dosen_email_polines", Auth::user()->email)->first()->dosen_id,
            'is_ketua' => 1,
            'is_verified' => 1
        ]);

        // Masuk ke trx_usulan_status
        DB::table('trx_usulan_status')->insert([
            'usulan_id' => $usulan_id,
            'status_id' => 1,
            'created_by' => DB::table("ref_dosen")->where("dosen_email_polines", Auth::user()->email)->first()->dosen_id,
            'created_at' => now(),
            'updated_at' => now(),
            'is_active' => 1
        ]);

        // Masuk ke trx_usulan_anggota_dosen (anggota)
        $id_dosen_anggota = $request->input('anggota_dosen');
        foreach ($id_dosen_anggota as $dosen_anggota_id) {
            DB::table('trx_usulan_anggota_dosen')->insert([
                'usulan_id' => $usulan_id,
                'dosen_id' => $dosen_anggota_id,
                'is_ketua' => 0,
                'is_verified' => 1
            ]);
        }

        // Masuk ke trx_usulan_anggota_mhs (anggota)
        $id_mhs_anggota = $request->input('anggota_mhs');
        foreach ($id_mhs_anggota as $mhs_anggota_id) {
            DB::table('trx_usulan_anggota_mhs')->insert([
                'usulan_id' => $usulan_id,
                'mhs_id' => $mhs_anggota_id,
            ]);
        }

        return redirect("/tambah_usulan?&step=2&usulan_id=$usulan_id&edit");
    }
    public function step_1(Request $request)
    {
        $skema_id = DB::table('trx_usulan')
            ->where('usulan_id', $request->usulan_id)->pluck('trx_skema_id')[0];
        $total_pendanaan = DB::table('trx_skema_settings')
            ->where('trx_skema_id', $skema_id)
            ->where('setting_key', 'max_dana')
            ->pluck('setting_value')[0];

        $get_total_pendanaan = $request->total;
        if ($get_total_pendanaan > $total_pendanaan) {
            toastr()->error('Total dana tidak boleh lebih dari Rp.' . $total_pendanaan);
            return back();
        } else {
            $skema_pendanaan = DB::table('trx_skema_pendanaan')
                ->where('trx_skema_id', $skema_id)
                ->get(['pendanaan_id', 'pendanaan_persentase']);
            // Validasi
            $count = 0;
            foreach ($skema_pendanaan as $key => $value) {
                $id_skema = $value->pendanaan_id;
                $max_value = $value->pendanaan_persentase * $get_total_pendanaan;
                $get_value = $request->$id_skema;
                if ($get_value > $max_value) {
                    toastr()->error('Melebihi persentase');
                    return back();
                } else {
                    $count += $get_value;
                }
            }
            // Insert Data
            if ($count != $get_total_pendanaan) {
                toastr()->error('Total Pendanaan dan Jumlah Detail Pendanaan tidak sesuai');
                return back();
            }
            foreach ($skema_pendanaan as $key => $value) {
                $id_skema = $value->pendanaan_id;
                $get_value = $request->$id_skema;
                DB::table('trx_usulan_dana')->insert([
                    'usulan_id' => $request->usulan_id,
                    'pendanaan_id' => $value->pendanaan_id,
                    'pendanaan_value' => $get_value
                ]);
            }
            DB::table('trx_usulan')
                ->where('usulan_id', $request->usulan_id)
                ->update([
                    'usulan_pendanaan'  => $count
                ]);
            return redirect("/tambah_usulan?&step=3&usulan_id=$request->usulan_id&edit");
        }
    }
    public function step_2(Request $request)
    {
        try {
            $nama_button = $request->input('btn-save');
            $usulan_id = $request->usulan_id;

            if ($nama_button == "Simpan Permanen") {
                DB::table('trx_usulan_status')
                    ->where('usulan_id', $usulan_id)
                    ->update([
                        'is_active' => '0'
                    ]);
                DB::table('trx_usulan_status')
                    ->insert([
                        'usulan_id' => $usulan_id,
                        'status_id' => 2,
                        'created_by' => DB::table("ref_dosen")->where("dosen_email_polines", Auth::user()->email)->first()->dosen_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'is_active' => 1
                    ]);
            }

            // Masukkan ke trx_usulan_luaran_tambahan
            $luaran_tambahan = $request->input('luaran');
            foreach ($luaran_tambahan as $key => $value) {
                DB::table('trx_usulan_luaran_tambahan')->insert([
                    'usulan_id' => $usulan_id,
                    'luaran_tambahan_id' => $value,
                ]);
            }

            // Masukkan ke trx_usulan_iku
            $iku = $request->input('iku');
            $realisasiIku = $request->realisasiIku;
            foreach ($iku as $key => $value) {
                DB::table('trx_usulan_iku')->insert([
                    'usulan_id' => $usulan_id,
                    'iku_id'    => $value,
                    'iku_target' => $realisasiIku[$key]
                ]);
            }

            // Masukkan ke trx_usulan_file
            $id_file = $request->input('id_file');

            $inputFile = $request->file('inputFile');
            foreach ($inputFile as $key => $value) {
                $random_string = Str::random(10);
                $nama_file = $random_string . '.' . $value->getClientOriginalExtension();
                DB::table('trx_usulan_file')
                    ->insert([
                        'usulan_id' => $usulan_id,
                        'skema_file_id' => $id_file[$key],
                        'file_name' => $nama_file,
                        'created_at' => now(),
                    ]);
                $value->storeAs('public/trx_usulan_file', $nama_file);
            }

            // Get skema id
            $get_Skema = DB::table('trx_usulan')->where('usulan_id', $usulan_id)->get('trx_skema_id');

            // Get Luaran Wajib
            $luaran_wajib = DB::table('trx_skema_luaran_wajib')
                ->where('trx_skema_id', $get_Skema[0]->trx_skema_id)
                ->get('luaran_wajib_id');

            // Insert Luaran Wajib ke
            foreach ($luaran_wajib as $key => $value) {
                DB::table('trx_usulan_luaran_wajib')
                    ->insert([
                        'usulan_id' => $usulan_id,
                        'luaran_wajib_id' => $value->luaran_wajib_id,
                    ]);
            }

            toastr()->success('Data berhasil di update');
            return redirect('/');
        } catch (\Throwable $th) {
            toastr()->error('Terjadi masalah pada server. Data user gagal ditambahkan.');
            return back();
        }
    }

    public function tambahUsulan()
    {
        $step = $_GET['step'];
        $luaran_tambahan = DB::table('ref_luaran_tambahan')->get();

        $data_dosen = DB::table('ref_dosen')->where('is_active', 1)->get();
        $data_mhs = DB::table('ref_mahasiswa')->get();

        $data = [
            "luaran_tambahan" => $luaran_tambahan,
            "step" => $step,
            "data_dosen" => $data_dosen,
            "data_mhs" => $data_mhs
        ];
        if ($step == 1) {
            if ($_GET['usulan_id'] == '') {
                $skema_id = $_GET['skema_id'];
            } else {
                $skema_id = DB::table('trx_usulan')
                    ->where('usulan_id', $_GET['usulan_id'])
                    ->pluck('trx_skema_id')[0];
            }
            $skema = DB::table('trx_skema')->where('trx_skema_id', $skema_id)->first();
            $skema_pendanaan = DB::table('trx_skema_pendanaan')->where('trx_skema_id', $skema_id)->get();
            $ref_iku = DB::table('ref_iku')->where('jenis_skema_id', $skema_id);

            $data['skema_id'] = $skema_id;
            $data['skema_nama'] = $skema->trx_skema_nama;
            $data['skema_pendanaan'] = $skema_pendanaan;
            $data['ref_iku'] = $ref_iku;
            $data['ketua_dosen'] = DB::table('ref_dosen')->where('dosen_email_polines', Auth::user()->email)
                ->get(['dosen_id', 'dosen_nama_lengkap']);

            if ($_GET['usulan_id']) {
                $usulan_id = $_GET['usulan_id'];
                $data['data_usulan'] = [
                    'skema' => DB::table('trx_usulan')->where('usulan_id', $usulan_id)
                        ->join('trx_skema', 'trx_usulan.trx_skema_id', '=', 'trx_skema.trx_skema_id')
                        ->get('trx_skema.trx_skema_nama'),
                    'usulan' => DB::table('trx_usulan')->where('usulan_id', $usulan_id)->get(['usulan_judul', 'usulan_abstrak']),
                    'anggota_dosen' => DB::table('trx_usulan_anggota_dosen')->where('usulan_id', $usulan_id)->where('is_ketua', 0)
                        ->join('ref_dosen', 'trx_usulan_anggota_dosen.dosen_id', '=', 'ref_dosen.dosen_id')
                        ->get(['dosen_nama_lengkap', 'ref_dosen.dosen_id']),
                    'anggota_mhs' => DB::table('trx_usulan_anggota_mhs')->where('usulan_id', $usulan_id)
                        ->join('ref_mahasiswa', 'trx_usulan_anggota_mhs.mhs_id', '=', 'ref_mahasiswa.mhs_id')
                        ->get(['mhs_nama', 'ref_mahasiswa.mhs_id']),
                ];
            }

            return view('daftar-usulan.step1', compact('data'));
        } else if ($step == 2) {
            $usulan_id = $_GET['usulan_id'];

            $data['skema_id'] = DB::table('trx_usulan')->where('usulan_id', $usulan_id)->pluck('trx_skema_id')[0];
            $data['max_dana'] = DB::table('trx_skema_settings')->where('trx_skema_id', $data['skema_id'])->where('setting_key', 'max_dana')->pluck('setting_value')[0];
            $data['pendanaan'] = DB::table('trx_skema_pendanaan')->where('trx_skema_id', $data['skema_id'])->get(['pendanaan_id', 'pendanaan_nama', 'pendanaan_persentase']);

            if ($_GET['edit'] == '1') {
                $data['total_pendanaan'] = DB::table('trx_usulan')
                    ->where('usulan_id', $usulan_id)
                    ->get('usulan_pendanaan');
                $data['detail_pendanaan'] = DB::table('trx_usulan_dana')
                    ->where('usulan_id', $usulan_id)
                    ->get('pendanaan_value');
            }

            return view('daftar-usulan.step2', compact('data'));
        } else if ($step == 3) {
            $usulan_id = $_GET['usulan_id'];
            $skema_id = DB::table('trx_usulan')
                ->where('usulan_id', $usulan_id)->pluck('trx_skema_id')[0];
            $data['trx_luaran_tambahan'] = DB::table('trx_skema_luaran_tambahan')
                ->join('ref_luaran_tambahan', 'trx_skema_luaran_tambahan.luaran_tambahan_id', '=', 'ref_luaran_tambahan.luaran_tambahan_id')
                ->where('trx_skema_luaran_tambahan.trx_skema_id', $skema_id)
                ->where('ref_luaran_tambahan.is_aktif', 1)
                ->get(['ref_luaran_tambahan.luaran_tambahan_id', 'luaran_tambahan_nama']);
            $data['ref_iku'] = DB::table('ref_iku')
                ->where('jenis_skema_id', $skema_id)
                ->where('is_active', 1)
                ->get();
            $data['skema_file'] = DB::table('trx_skema_file')
                ->where('trx_skema_id', $skema_id)
                ->where('is_active', 1)
                ->get(['skema_file_id', 'file_key', 'file_caption', 'file_accepted_type', 'is_required']);
            if ($_GET['edit'] == 1) {
                $data['luaran_tambahan'] = DB::table('trx_usulan_luaran_tambahan')
                    ->join('ref_luaran_tambahan', 'trx_usulan_luaran_tambahan.luaran_tambahan_id', '=', 'ref_luaran_tambahan.luaran_tambahan_id')
                    ->where('trx_usulan_luaran_tambahan.usulan_id', $usulan_id)
                    ->get([
                        'trx_usulan_luaran_tambahan.luaran_tambahan_id',
                        'luaran_tambahan_nama',
                        'luaran_tambahan_target'
                    ]);
                $data['iku'] = DB::table('trx_usulan_iku')
                    ->join('ref_iku', 'trx_usulan_iku.iku_id', '=', 'ref_iku.iku_id')
                    ->where('trx_usulan_iku.usulan_id', $usulan_id)
                    ->get([
                        'trx_usulan_iku.iku_id',
                        'iku_nama',
                        'trx_usulan_iku.iku_target'
                    ]);
                $data['berkas'] = DB::table('trx_usulan_file')
                    ->join('trx_skema_file', 'trx_usulan_file.skema_file_id', '=', 'trx_skema_file.skema_file_id')
                    ->where('trx_usulan_file.usulan_id', $usulan_id)
                    ->get([
                        'trx_usulan_file.skema_file_id',
                        'file_name'
                    ]);
            }
            return view('daftar-usulan.step3', compact('data'));
        }
    }
    public function detail()
    {
        $usulan_id = $_GET['usulan_id'];

        // Data Penelitian
        $data_penelitian = DB::table('trx_usulan')
            ->join('trx_skema', 'trx_usulan.trx_skema_id', '=', 'trx_skema.trx_skema_id')
            ->where('usulan_id', $usulan_id)->get(['trx_skema_nama', 'usulan_judul', 'usulan_abstrak']);

        // Capaian
        $luaran_wajib = DB::table('trx_usulan_luaran_wajib')
            ->join('ref_luaran_wajib', 'trx_usulan_luaran_wajib.luaran_wajib_id', '=', 'ref_luaran_wajib.luaran_id')
            ->where('usulan_id', $usulan_id)
            ->get(['luaran_wajib_nama', 'luaran_wajib_deskripsi']);
        $luaran_tambahan = DB::table('trx_usulan_luaran_tambahan')
            ->join('ref_luaran_tambahan', 'trx_usulan_luaran_tambahan.luaran_tambahan_id', '=', 'ref_luaran_tambahan.luaran_tambahan_id')
            ->where('usulan_id', $usulan_id)
            ->get(['luaran_tambahan_nama', 'luaran_tambahan_target']);
        $iku = DB::table('trx_usulan_iku')
            ->join('ref_iku', 'trx_usulan_iku.iku_id', '=', 'ref_iku.iku_id')
            ->where('usulan_id', $usulan_id)
            ->get(['iku_nama', 'trx_usulan_iku.iku_target', 'iku_bukti', 'ref_iku.iku_id']);

        // Anggota
        $dosen = DB::table('trx_usulan_anggota_dosen')
            ->join('ref_dosen', 'trx_usulan_anggota_dosen.dosen_id', '=', 'ref_dosen.dosen_id')
            ->where('usulan_id', $usulan_id);
        $dosen_ketua = $dosen->where('is_ketua', 1)->get(['dosen_nama_lengkap', 'is_verified']);
        $dosen_anggota = DB::table('trx_usulan_anggota_dosen')
            ->join('ref_dosen', 'trx_usulan_anggota_dosen.dosen_id', '=', 'ref_dosen.dosen_id')
            ->where('usulan_id', $usulan_id)
            ->where('is_ketua', 0)
            ->get();
        $mahasiswa = DB::table('trx_usulan_anggota_mhs')
            ->join('ref_mahasiswa', 'trx_usulan_anggota_mhs.mhs_id', '=', 'ref_mahasiswa.mhs_id')
            ->join('ref_prodi', 'ref_mahasiswa.prodi_id', '=', 'ref_prodi.prodi_id')
            ->where('usulan_id', $usulan_id)
            ->get(['ref_mahasiswa.mhs_id', 'mhs_nama', 'prodi_nama', 'prodi_jenjang']);

        // Berkas Usulan
        $berkas = DB::table('trx_usulan_file')
            ->join('trx_skema_file', 'trx_usulan_file.skema_file_id', '=', 'trx_skema_file.skema_file_id')
            ->where('usulan_id', $usulan_id)
            ->get(['file_caption', 'file_name', 'file_status']);

        // Komponen Pendanaan
        $total_pendanaan = DB::table('trx_usulan')
            ->where('usulan_id', $usulan_id)->get('usulan_pendanaan');
        $detail_pendanaan = DB::table('trx_usulan_dana')
            ->join('trx_skema_pendanaan', 'trx_usulan_dana.pendanaan_id', '=', 'trx_skema_pendanaan.pendanaan_id')
            ->where('usulan_id', $usulan_id)
            ->get(['pendanaan_value', 'pendanaan_nama', 'pendanaan_persentase']);

        // Compress Data
        $DataPenelitian = $data_penelitian;
        $Capaian = [
            'luaran_wajib' => $luaran_wajib,
            'luaran_tambahan' => $luaran_tambahan,
            'iku' => $iku
        ];
        $Anggota = [
            'dosen_ketua' => $dosen_ketua,
            'dosen_anggota' => $dosen_anggota,
            'mahasiswa' => $mahasiswa
        ];
        $BerkasUsulan = $berkas;
        $KomponenPendanaan = [
            'total_pendanaan' => $total_pendanaan,
            'detail_pendanaan' => $detail_pendanaan
        ];

        $data = [
            'data_penelitian' => $DataPenelitian,
            'capaian'         => $Capaian,
            'anggota'         => $Anggota,
            'berkas_usulan'   => $BerkasUsulan,
            'komponen_pendanaan' => $KomponenPendanaan
        ];

        return view('daftar-usulan.detail', compact('data'));
    }
}
