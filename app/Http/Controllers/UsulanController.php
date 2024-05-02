<?php

namespace App\Http\Controllers;

use App\Models\Trx_usulan;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsulanController extends Controller
{
    public function lihat_usulan()
    {
        $dosen_id = DB::table("ref_dosen")->where("dosen_email_polines", Auth::user()->email)->first();
        $lihat_usulan_dosen = DB::table("trx_usulan_anggota_dosen")->where("dosen_id", $dosen_id->dosen_id)->get();

        $data = [];
        foreach ($lihat_usulan_dosen as $key => $value) {
            $judul_usulan = DB::table('trx_usulan')->where('usulan_id', $value->usulan_id)->first();
            $nama_skema  = DB::table('trx_skema')->where('trx_skema_id', $judul_usulan->trx_skema_id)->first();
            $id_ketua = DB::table("trx_usulan_anggota_dosen")->where("usulan_id", $value->usulan_id)->where("is_ketua", 1)->pluck('dosen_id');
            // $id_anggota_dosen = DB::table("trx_usulan_anggota_dosen")->where("usulan_id", $value->usulan_id)->where("is_ketua", 0)->pluck('dosen_id');
            // $status = DB::table('trx_usulan_status')->where('usulan_id', $value->usulan_id)->first();

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

        return redirect("/tambah_usulan?&step=2&usulan_id=$usulan_id");
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
            return redirect("/tambah_usulan?&step=3&usulan_id=$request->usulan_id");
        }
    }
    public function step_2()
    {
    }
    public function index()
    {
        $usulan = $this->lihat_usulan();
        $dosen_id = DB::table("ref_dosen")->where("dosen_email_polines", Auth::user()->email)->first();
        $count_usulan = DB::table("trx_usulan_anggota_dosen")->where("dosen_id", $dosen_id->dosen_id)->count();
        return view('usulan.index', compact('usulan', 'count_usulan'));
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
            $skema_id = $_GET['skema_id'];
            $skema = DB::table('trx_skema')->where('trx_skema_id', $skema_id)->first();
            $skema_pendanaan = DB::table('trx_skema_pendanaan')->where('trx_skema_id', $skema_id)->get();
            $ref_iku = DB::table('ref_iku')->where('jenis_skema_id', $skema_id);

            $data['skema_id'] = $skema_id;
            $data['skema_nama'] = $skema->trx_skema_nama;
            $data['skema_pendanaan'] = $skema_pendanaan;
            $data['ref_iku'] = $ref_iku;

            return view('usulan.step1', compact('data'));
        } else if ($step == 2) {
            $usulan_id = $_GET['usulan_id'];

            $data['skema_id'] = DB::table('trx_usulan')->where('usulan_id', $usulan_id)->pluck('trx_skema_id')[0];
            $data['max_dana'] = DB::table('trx_skema_settings')->where('trx_skema_id', $data['skema_id'])->where('setting_key', 'max_dana')->pluck('setting_value')[0];
            $data['pendanaan'] = DB::table('trx_skema_pendanaan')->where('trx_skema_id', $data['skema_id'])->get(['pendanaan_id', 'pendanaan_nama', 'pendanaan_persentase']);
            return view('usulan.step2', compact('data'));
        } else if ($step == 3) {
            return view('usulan.step3', compact('data'));
        }
    }
    public function detail()
    {
        return view('usulan.detail');
    }
}
