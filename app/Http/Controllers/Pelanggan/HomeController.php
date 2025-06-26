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
    $categories = Category::all();

    // Base query untuk JS dan paginasi
    $baseQuery = Product::with(['mainImage', 'category']);

    // Untuk pagination
    $paginatedQuery = clone $baseQuery;

    // Filter kategori & pencarian (kedua query harus difilter sama)
    if ($request->filled('category')) {
        $baseQuery->where('category_id', $request->category);
        $paginatedQuery->where('category_id', $request->category);
    }

    if ($request->filled('search')) {
        $baseQuery->where('name', 'like', '%' . $request->search . '%');
        $paginatedQuery->where('name', 'like', '%' . $request->search . '%');
    }

    // Produk untuk HTML (12 pertama, paginasi)
    $products = $paginatedQuery->latest()->paginate(12);

    // Produk lengkap untuk JS
    $productsForJs = $baseQuery->get()->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => 'Rp ' . number_format($product->base_price ?? $product->price, 0, ',', '.'),
            'category' => Str::slug(optional($product->category)->name),
            'image' => asset('storage/' . ($product->mainImage->image_path ?? 'images/default.jpg')),
            'url' => route('pelanggan.products.show', $product->id),
        ];
    });

    return view('pelanggan.home', compact('products', 'categories', 'productsForJs'));
}

}
