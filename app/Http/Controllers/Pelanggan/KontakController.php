<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

class KontakController extends Controller
{
    public function index()
    {
        return view('pelanggan.kontak', [
            'title' => 'Kontak'
        ]);
    }
}
