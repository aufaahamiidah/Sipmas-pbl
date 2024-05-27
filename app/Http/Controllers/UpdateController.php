<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function update_step0(Request $request)
    {
        try {
            $this->validate($request, [
                'judul' => 'required',
                'abstrak' => 'required'
            ]);
            $usulan_id = $request->usulan_id;

            //Update trx_usulan
            DB::table('trx_usulan')
                ->where('usulan_id', $usulan_id)
                ->update([
                    'usulan_judul' => $request->judul,
                    'abstrak'      => $request->abstrak
                ]);

            //Hapus data dosen terlebih dahulu
            DB::table('trx_usulan_anggota_dosen')
                ->where('usulan_id', $usulan_id)
                ->where('is_ketua', 0)
                ->delete();

            //insert data anggota dosen baru
            $id_dosen_anggota = $request->input('anggota_dosen');
            foreach ($id_dosen_anggota as $item) {
                DB::table('trx_usulan_anggota_dosen')
                    ->insert([
                        'usulan_id' => $usulan_id,
                        'dosen_id' => $item,
                        'is_ketua' => 0,
                        'is_verified' => 1

                    ]);
            }

            //Hapus data mhs terlebih dahulu
            DB::table('trx_usulan_anggota_mhs')
                ->where('usulan_id', $usulan_id)
                ->delete();

            //Insert data anggota mhs
            $id_mhs_anggota = $request->input('anggota_mhs');
            foreach ($id_mhs_anggota as $item) {
                DB::table('trx_usulan_anggota_mhs')->insert([
                    'usulan_id' => $usulan_id,
                    'mhs_id' => $item
                ]);
            }
            return redirect("/tambah_usulan?&step=2&usulan_id=$usulan_id&edit=1");
        } catch (\Throwable $th) {
            toastr()->error('Gagal mengupdate data');
        }
    }

    public function update_step1(Request $request)
    {
        $usulan_id = $request->usulan_id;
        $skema_id = DB::table('trx_usulan')
            ->where('usulan_id', $usulan_id)
            ->pluck('trx_skema_id')[0];
        $max_value = DB::table('trx_skema_settings')
            ->where('trx_skema_id', $skema_id)
            ->where('setting_key', 'max_dana')
            ->pluck('setting_value')[0];
        $total = $request->total;

        //validasi 1
        if ($total . $max_value) {
            toastr()->error('Total dana melebihi ' . $max_value);
            return back();
        }
        //validasi 2
        $skema_pendanaan = DB::table('trx_skema_pendanaan')
            ->where('trx_skema_id', $skema_id)
            ->get(['pendanaan_id', 'pendanaan_persentase']);

        foreach ($skema_pendanaan as $key => $value) {
            $id_skema = $value->pendanaan_id;
            $persentase = $value->pendanaan_persentase;
            $max_value = $total * $persentase;
            if ($request->$id_skema > $max_value) {
                toastr()->error('Dana melebihi anggaran');
                return back();
            }
        }
        // Validasi 3
        $tampung_value = 0;
        foreach ($skema_pendanaan as $key => $value) {
            $tampung_value += $request->$value->pendanaan_id;
        }
        if ($tampung_value != $request->$total) {
            toastr()->error('Dana tidak sesuai dengan total dana');
            return back();
        }

        //delete
        DB::table('trx_usulan_dana')
            ->insert([
                'usulan_id' => $usulan_id,
                'pendanaan_id' => $value->pendanaan_id,
                'pendanaan_value' => $request->$value->pendanaan_id
            ]);
        toastr()->success('Berhasil update dana');
        return redirect("/tambah_usulan?&step=3&usulan_id=$usulan_id&edit=1");
    }

    public function update_step2()
    {
    }
}
