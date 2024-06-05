<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpanFileController extends Controller
{
    public function iku(Request $request)
    {
        $iku = $request->file('iku');
        $id_iku = $request->input('id_iku');

        foreach ($iku as $key => $value) {
            $random_string = Str::random(10);
            $nama_file = $random_string . '.' . $value->getClientOriginalExtension();
            DB::table('trx_usulan_iku')
                ->where('iku_id', $id_iku[$key])
                ->where('usulan_id', $request->usulan_id)
                ->update([
                    'iku_bukti' => $nama_file
                ]);
            $value->storeAs('public/iku', $nama_file);
        }
        return back();
    }
}
