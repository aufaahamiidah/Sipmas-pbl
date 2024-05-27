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

    public function update_step1()
    {
    }

    public function update_step2()
    {
    }
}
