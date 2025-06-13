<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori untuk filter (optional)
        $categories = Category::all();

        // Query produk dengan eager loading kategori dan gambar utama (pastikan relasi mainImage ada di model Product)
        $query = Product::with(['mainImage', 'category']);

        // Filter kategori (jika ada)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter pencarian (jika ada)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Produk paginasi untuk tampil di blade (optional)
        $products = $query->latest()->paginate(12);

        // Data produk lengkap untuk dipakai di JavaScript (tanpa paginasi)
        $productsForJs = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => 'Rp ' . number_format($product->base_price ?? $product->price, 0, ',', '.'),
                'category' => Str::slug(optional($product->category)->name), // <- penting untuk JS filter
                'image' => asset('storage/' . ($product->mainImage->image_path ?? 'images/default.jpg')),
'url' => route('pelanggan.products.show', $product->id),

            ];
        });

        return view('pelanggan.home', compact('products', 'categories', 'productsForJs'));
    }
}
