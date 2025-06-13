<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Material;
use App\Models\Size;
use App\Models\Lamination;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    /**
     * Tampilkan detail produk dan form pemesanan.
     */
   public function show($id)
{
    $product = Product::with(['category', 'mainImage', 'images'])->findOrFail($id);
    $materials = Material::all();
    $sizes = Size::all();
    $laminations = Lamination::all();

    // Decode kolom form_fields (berformat JSON) jadi array
    $formFields = json_decode($product->form_fields, true);

    // Ambil produk terkait (dari kategori yang sama, kecuali produk saat ini)
    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(3)
        ->get();

    // Nama view form khusus (jika ada)
    $viewName = 'pelanggan.products.forms.' . $product->slug;

    if (view()->exists($viewName)) {
        return view($viewName, compact(
            'product', 'materials', 'sizes', 'laminations', 'formFields', 'relatedProducts'
        ));
    }

    return view('pelanggan.products.show', compact(
        'product', 'materials', 'sizes', 'laminations', 'formFields', 'relatedProducts'
    ));
}


    /**
     * Menyimpan pesanan.
     */
    public function order(Request $request, $id)
    {
        // TODO: Validasi dan simpan data pesanan di sini
        // kamu bisa validasi dynamic fields juga di sini
    }
}
