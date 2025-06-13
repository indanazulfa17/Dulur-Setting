<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

class TentangController extends Controller
{
    public function index()
    {
        return view('pelanggan.tentang', [
            'title' => 'Tentang'
        ]);
    }
}