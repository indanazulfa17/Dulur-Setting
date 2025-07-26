<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

class BantuanController extends Controller
{
    public function index()
    {
        return view('pelanggan.bantuan', [
            'title' => 'Bantuan'
        ]);
    }
}
