<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
        return view('edit_profil');
    }

    public function getUsulanTema()
    {
        $skema = DB::table("ref_jenis_skema")->get();
        $data = [];

        foreach ($skema as $key => $value) {
            $data[$key]["skema_id"] = $value->jenis_skema_id;
            $data[$key]["skema_icon"] = $value->jenis_skema_icon;
            $data[$key]["skema_color"] = $value->jenis_skema_color;
            $data[$key]["skema_nama"] = $value->jenis_skema_nama;
            $data[$key]["trx_skema"] = array();

            $trx_skema = DB::table("trx_skema")->where("jenis_skema_id", $value->jenis_skema_id)->get()->map(function ($item) {
                return [$item->trx_skema_nama];
            })->toArray();
            foreach ($trx_skema as $trxKey) {
                array_push($data[$key]["trx_skema"], $trxKey);
            }
        }
        return response()->json($data);
    }
}
