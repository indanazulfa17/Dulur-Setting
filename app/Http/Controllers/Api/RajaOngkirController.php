<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => 'JIsmxdvB3ac7743d52b5523aNHxiZpyF'
        ])->get('https://api.rajaongkir.com/starter/province');

        return response()->json([
            'provinces' => $response['rajaongkir']['results']
        ]);
    }

    public function getCities(Request $request)
    {
        $provinceId = $request->query('province_id');

        $response = Http::withHeaders([
            'key' => 'JIsmxdvB3ac7743d52b5523aNHxiZpyF'
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $provinceId
        ]);

        return response()->json([
            'cities' => $response['rajaongkir']['results']
        ]);
    }
}
