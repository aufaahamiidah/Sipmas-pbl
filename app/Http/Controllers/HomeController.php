<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Psy\Util\Json;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $get_dosen = DB::table('ref_dosen')->where('dosen_email_polines', Auth::user()->email);
        $data_dosen = $get_dosen->count();

        $data[] = [
            'nip' => $get_dosen->pluck('dosen_id'),
            'dosen_nama_lengkap' => $get_dosen->pluck('dosen_nama_lengkap'),
            'dosen_email' => $get_dosen->pluck('dosen_email_polines'),
            'dosen_nidn' => $get_dosen->pluck('dosen_nidn'),
            'dosen_sinta_id' => $get_dosen->pluck('dosen_sinta_id'),
        ];

        // Jika data user ada di ref_dosen, maka akan dialihkan ke home dashboard
        if ($data_dosen > 0) {
            return view('home.home', compact('data'));
        }

        session()->flash("warningMsg", "Data anda belum terdaftar di data dosen. Silahkan isi form berikut untuk mengakses penuh halaman dashboard (Minimal isi form yang bertanda *).");
        return view('home.edit_profil');
    }
    public function showEditData()
    {
        $query = DB::table("ref_dosen")->where("dosen_email_polines", Auth::user()->email)->first();
        return view('home.edit_profil', compact("query"));
    }
    public function editData(Request $request)
    {
        $request->validate([
            'dosen_id' => ['required'],
        ]);

        $email = Auth::user()->email;
        $getDataDosen = DB::table("ref_dosen")->where("dosen_email_polines", $email)->get()->count();
        if ($getDataDosen > 0) {
            // Jika data user sudah ada di ref_dosen, maka lakukan update data ref_dosen
            DB::table("ref_dosen")->where("dosen_email_polines", $email)->update([
                "dosen_id"  => $request->dosen_id,
                "dosen_nama" => $request->dosen_nama,
                "dosen_gelar_depan" => $request->dosen_gelar_depan,
                "dosen_gelar_belakang" => $request->dosen_gelar_belakang,
                "dosen_nama_lengkap" => $request->dosen_gelar_depan . "" . $request->dosen_nama . ", " . $request->dosen_gelar_belakang,
                "dosen_nidn" => $request->dosen_nidn,
                "dosen_nik" => null,
                "dosen_sinta_id" => $request->dosen_sinta_id,
                "dosen_email_polines" => $email,
                "prodi_id"  => $request->prodi_id,
                "pendidikan_id" => $request->pendidikan_id,
                "jabfung_id" => $request->jabfung_id,
                "api_json_data" => null,
                "is_active"     => 1
            ]);
        } else {
            // Jika belum, maka lakukan insert data ref_dosen
            DB::table("ref_dosen")->insert([
                "dosen_id"  => $request->dosen_id,
                "dosen_nama" => $request->dosen_nama,
                "dosen_gelar_depan" => $request->dosen_gelar_depan,
                "dosen_gelar_belakang" => $request->dosen_gelar_belakang,
                "dosen_nama_lengkap" => $request->dosen_gelar_depan . "" . $request->dosen_nama . ", " . $request->dosen_gelar_belakang,
                "dosen_nidn" => $request->dosen_nidn,
                "dosen_nik" => null,
                "dosen_sinta_id" => $request->dosen_sinta_id,
                "dosen_email_polines" => $email,
                "prodi_id"  => $request->prodi_id,
                "pendidikan_id" => $request->pendidikan_id,
                "jabfung_id" => $request->jabfung_id,
                "api_json_data" => null,
                "is_active"     => 1
            ]);
            return redirect('/');
        }
    }
}
