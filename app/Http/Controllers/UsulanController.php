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
            $id_anggota_dosen = DB::table("trx_usulan_anggota_dosen")->where("usulan_id", $value->usulan_id)->where("is_ketua", 0)->pluck('dosen_id');
            $status = DB::table('trx_usulan_status')->where('usulan_id', $value->usulan_id)->first();

            $data[$key] = [
                "usulan_judul" => $judul_usulan->usulan_judul,
                "usulan_abstrak" => $judul_usulan->usulan_abstrak,
                "nama_skema"   => $nama_skema->trx_skema_nama,
                "ketua" => DB::table('ref_dosen')->where('dosen_id', $id_ketua)->first(),
                "pendanaan" => DB::table('trx_usulan_dana')->where('usulan_id', $value->usulan_id)->first()->pendanaan_value,
                "status_id" => $status->status_id
            ];
        }
        return $data;
    }
    public function index()
    {
        $usulan = $this->lihat_usulan();
        return view('usulan.index', compact('usulan'));
    }
    public function tambahUsulan()
    {
        return view('usulan.tambah_usulan');
    }
}
