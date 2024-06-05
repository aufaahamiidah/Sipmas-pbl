<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function download($file)
    {
        $file = basename($file);
        $filePath = storage_path('app/public/trx_usulan_file/' . $file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function downloadIku($file)
    {
        $file = basename($file);
        $filePath = storage_path('app/public/iku/' . $file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function downloadLWajib($file)
    {
        $file = basename($file);
        $filePath = storage_path('app/public/l_wajib/' . $file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function downloadLTambahan($file)
    {
        $file = basename($file);
        $filePath = storage_path('app/public/l_tambahan/' . $file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}
