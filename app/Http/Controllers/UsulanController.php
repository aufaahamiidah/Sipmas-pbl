<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsulanController extends Controller
{
    public function index()
    {
        return view('usulan.index');
    }
}
