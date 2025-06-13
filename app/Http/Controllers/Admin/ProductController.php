<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'mainImage'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'category_id' => 'required',
        ]);

        // Simpan produk ke tabel products
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'base_price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        // Simpan gambar ke tabel product_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
             $path = $image->store('products', 'public'); // ✅ Benar

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'created_at' => now()->addSeconds($index), // jaga urutan untuk mainImage
            ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'category_id' => 'required',
        ]);

        // Update data produk
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'base_price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        // Tambahkan gambar baru jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
             $path = $image->store('products', 'public'); // ✅ Benar

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'created_at' => now()->addSeconds($index), // jaga urutan
            ]);
        }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
    // Hapus semua gambar terkait jika ada
        foreach ($product->images as $image) {
        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
    }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

}
