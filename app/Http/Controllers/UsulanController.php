<?php

namespace App\Http\Controllers;

use App\Models\Trx_usulan;
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
            $status = DB::table('trx_usulan_status')->where('usulan_id', $value->usulan_id)->first();

            $data[$key] = [
                "usulan_id" =>  $value->usulan_id,
                "usulan_judul" => $judul_usulan->usulan_judul,
                "usulan_abstrak" => $judul_usulan->usulan_abstrak,
                "skema_id" => $judul_usulan->trx_skema_id,
                "nama_skema"   => $nama_skema->trx_skema_nama,
                "ketua" => DB::table('ref_dosen')->where('dosen_id', $id_ketua)->first(),
                "count_pendanaan" => DB::table('trx_usulan_dana')->where('usulan_id', $value->usulan_id)->count(),
                "pendanaan" => DB::table('trx_usulan_dana')->where('usulan_id', $value->usulan_id),
                "status_id" => $status->status_id,
                "anggota_dosen" => DB::table('trx_usulan_anggota_dosen')->where('is_ketua', 0)->where('usulan_id', $value->usulan_id)->pluck('dosen_id'),
                "anggota_mhs" => DB::table('trx_usulan_anggota_mhs')->where('usulan_id', $value->usulan_id)->pluck('mhs_id')
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

        return redirect('/');
    }
    public function step_1()
    {
    }
    public function step_2()
    {
    }
    public function step_3()
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
        $skema_id = $_GET['skema_id'];
        $step = $_GET['step'];

        $skema = DB::table('trx_skema')->where('trx_skema_id', $skema_id)->first();
        $skema_pendanaan = DB::table('trx_skema_pendanaan')->where('trx_skema_id', $skema_id)->get();
        $luaran_tambahan = DB::table('ref_luaran_tambahan')->get();
        $ref_iku = DB::table('ref_iku')->where('jenis_skema_id', $skema_id);
        $data_dosen = DB::table('ref_dosen')->where('is_active', 1)->get();
        $data_mhs = DB::table('ref_mahasiswa')->get();

        $data = [
            "skema_id" => $skema_id,
            "skema_nama" => $skema->trx_skema_nama,
            "skema_pendanaan" => $skema_pendanaan,
            "luaran_tambahan" => $luaran_tambahan,
            "ref_iku" => $ref_iku,
            "step" => $step,
            "data_dosen" => $data_dosen,
            "data_mhs" => $data_mhs
        ];
        return view('usulan.tambah_usulan', compact('data'));
    }
    public function detail()
    {
        return view('usulan.detail');
    }
}
