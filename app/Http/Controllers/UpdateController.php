<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateController extends Controller
{
    public function step0(Request $request)
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
                    'usulan_abstrak'      => $request->abstrak
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
            return back();
        }
    }

    public function step1(Request $request)
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
        if ($total > $max_value) {
            toastr()->error('Total dana melebihi ' . $max_value);
            return back();
        }
        //validasi 2
        $skema_pendanaan = DB::table('trx_skema_pendanaan')
            ->where('trx_skema_id', $skema_id)
            ->get(['pendanaan_id', 'pendanaan_persentase']);

        $tampung_value = 0;
        foreach ($skema_pendanaan as $key => $value) {
            $id_skema = $value->pendanaan_id;
            $persentase = $value->pendanaan_persentase;
            $max_value = $total * $persentase;
            if ($request->$id_skema > $max_value) {
                toastr()->error('Dana melebihi anggaran');
                return back();
            } else {
                $tampung_value += $request->$id_skema;
            }
        }
        // Validasi 3
        if ($tampung_value != $total) {
            toastr()->error('Dana tidak sesuai dengan total dana');
            return back();
        }

        //delete trx_usulan_dana
        DB::table('trx_usulan_dana')
            ->where('usulan_id', $usulan_id)
            ->delete();

        // Insert trx_usulan_dana
        foreach ($skema_pendanaan as $key => $value) {
            $id_skema = $value->pendanaan_id;
            $get_value = $request->$id_skema;
            DB::table('trx_usulan_dana')->insert([
                'usulan_id' => $usulan_id,
                'pendanaan_id' => $value->pendanaan_id,
                'pendanaan_value' => $get_value
            ]);
        }

        // Update pendanaan_value trx_usulan
        DB::table('trx_usulan')
            ->where('usulan_id', $usulan_id)
            ->update([
                'usulan_pendanaan'  => $tampung_value
            ]);

        toastr()->success('Berhasil update dana');
        return redirect("/tambah_usulan?&step=3&usulan_id=$usulan_id&edit=1");
    }

    public function step2(Request $request)
    {
        try {
            //Delete berkas
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

            $get_usulan_file = DB::table('trx_usulan_file')->where('usulan_id', $usulan_id);
            $deleted_file = $get_usulan_file->get(['file_name']);
            foreach ($deleted_file as $key => $value) {
                Storage::delete('public/trx_usulan_file/' . $value->file_name);
            }
            $get_usulan_file->delete();

            // Masukkan ke trx_usulan_file
            $id_file = $request->id_file;
            $namaFile = $request->inputFile;

            $inputFile = $request->file('inputFile');
            foreach ($inputFile as $key => $value) {
                $random_string = Str::random(10);
                $nama_file = $random_string . '.' . $value->getClientOriginalExtension();
                DB::table('trx_usulan_file')
                    ->insert([
                        'usulan_id' => $usulan_id,
                        'skema_file_id' => $id_file[$key],
                        'file_name' => $namaFile[$key],
                        'created_at' => now(),
                    ]);
                $value->storeAs('public/trx_usulan_file', $nama_file);
            }

            // Delete Luaran Tambahan
            DB::table('trx_usulan_luaran_tambahan')
                ->where('usulan_id', $usulan_id)
                ->delete();

            // Masukkan ke trx_usulan_luaran_tambahan
            $luaran_tambahan = $request->input('luaran');
            $target_luaran_tambahan = $request->input('targetLuaran');
            foreach ($luaran_tambahan as $key => $value) {
                DB::table('trx_usulan_luaran_tambahan')->insert([
                    'usulan_id' => $usulan_id,
                    'luaran_tambahan_id' => $value,
                    'luaran_tambahan_target' => $target_luaran_tambahan[$key]
                ]);
            }

            // Delete IKU
            DB::table('trx_usulan_IKU')
                ->where('usulan_id', $usulan_id)
                ->delete();

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
            toastr()->success('IKU berhasil di update');
            return redirect('/');
        } catch (\Throwable $th) {
            toastr()->error('IKU Gagal di update');
            return back();
        }
    }
}
