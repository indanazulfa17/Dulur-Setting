<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Material;
use App\Models\Size;
use App\Models\Lamination;
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
        $materials = Material::all();
        $sizes = Size::all();
        $laminations = Lamination::all();

        return view('admin.products.create', compact('categories', 'materials', 'sizes', 'laminations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'form_fields_json' => 'nullable|string',
            'dynamic_fields' => $request->input('form_fields', []),
        ]);

        $formFields = null;
        if (!empty($request->form_fields_json)) {
            $decoded = json_decode($request->form_fields_json, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $formFields = json_encode($decoded);
            }
        }

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'base_price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'form_fields' => $formFields,
            'dynamic_fields' => $request->input('form_fields', []),
        ]);

        // Simpan gambar produk
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'created_at' => now()->addSeconds($index),
                ]);
            }
        }

        // Simpan bahan baru
        if ($request->filled('new_materials')) {
            foreach ($request->new_materials as $new) {
                if (!empty($new['name'])) {
                    $material = Material::create(['name' => $new['name']]);
                    $product->materials()->attach($material->id, [
                        'additional_price' => $new['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Simpan ukuran baru
        if ($request->filled('new_sizes')) {
            foreach ($request->new_sizes as $new) {
                if (!empty($new['name']) && !empty($new['dimension'])) {
                    $size = Size::create([
                        'name' => $new['name'],
                        'dimension' => $new['dimension'],
                    ]);
                    $product->sizes()->attach($size->id, [
                        'additional_price' => $new['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Simpan laminasi baru
        if ($request->filled('new_laminations')) {
            foreach ($request->new_laminations as $new) {
                if (!empty($new['name'])) {
                    $lamination = Lamination::create(['name' => $new['name']]);
                    $product->laminations()->attach($lamination->id, [
                        'additional_price' => $new['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Tambahkan "Tanpa Laminasi" jika belum ada
        $tanpaLaminasi = Lamination::firstOrCreate(['name' => 'Tanpa Laminasi']);
        if (!$product->laminations->contains($tanpaLaminasi->id)) {
            $product->laminations()->attach($tanpaLaminasi->id, ['additional_price' => 0]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $materials = Material::all();
        $sizes = Size::all();
        $laminations = Lamination::all();

        $product->load(['images', 'materials', 'sizes', 'laminations']);

        return view('admin.products.edit', compact('product', 'categories', 'materials', 'sizes', 'laminations'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'form_fields_json' => 'nullable|string',
            'dynamic_fields' => $request->input('form_fields', []),
        ]);

        $formFields = null;
        if (!empty($request->form_fields_json)) {
            $decoded = json_decode($request->form_fields_json, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $formFields = json_encode($decoded);
            }
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'base_price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'form_fields' => $formFields,
            'dynamic_fields' => $request->input('form_fields', []),
        ]);

        // Hapus gambar jika diminta
        if ($request->has('existing_images')) {
            foreach ($request->existing_images as $imgData) {
                if (isset($imgData['delete']) && $imgData['delete']) {
                    $image = ProductImage::find($imgData['id']);
                    if ($image && Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image?->delete();
                }
            }
        }

        // Tambah gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'created_at' => now()->addSeconds($index),
                ]);
            }
        }

        // Update / hapus bahan
        if ($request->has('materials')) {
            foreach ($request->materials as $data) {
                if (!empty($data['delete'])) {
                    $product->materials()->detach($data['id']);
                } else {
                    $product->materials()->updateExistingPivot($data['id'], [
                        'additional_price' => $data['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Tambah bahan baru
        if ($request->filled('new_materials')) {
            foreach ($request->new_materials as $new) {
                if (!empty($new['name'])) {
                    $material = Material::create(['name' => $new['name']]);
                    $product->materials()->attach($material->id, [
                        'additional_price' => $new['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Update / hapus ukuran
        if ($request->has('sizes')) {
            foreach ($request->sizes as $data) {
                if (!empty($data['delete'])) {
                    $product->sizes()->detach($data['id']);
                } else {
                    $product->sizes()->updateExistingPivot($data['id'], [
                        'additional_price' => $data['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Tambah ukuran baru
        if ($request->filled('new_sizes')) {
            foreach ($request->new_sizes as $new) {
                if (!empty($new['name'])) {
                    $size = Size::create([
                        'name' => $new['name'],
                        'dimension' => $new['dimension'] ?? null,
                    ]);
                    $product->sizes()->attach($size->id, [
                        'additional_price' => $new['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Update / hapus laminasi
        if ($request->has('laminations')) {
            foreach ($request->laminations as $data) {
                if (!empty($data['delete'])) {
                    $product->laminations()->detach($data['id']);
                } else {
                    $product->laminations()->updateExistingPivot($data['id'], [
                        'additional_price' => $data['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Tambah laminasi baru
        if ($request->filled('new_laminations')) {
            foreach ($request->new_laminations as $new) {
                if (!empty($new['name'])) {
                    $lamination = Lamination::create(['name' => $new['name']]);
                    $product->laminations()->attach($lamination->id, [
                        'additional_price' => $new['additional_price'] ?? 0,
                    ]);
                }
            }
        }

        // Tambahkan "Tanpa Laminasi" jika belum ada
        $tanpaLaminasi = Lamination::firstOrCreate(['name' => 'Tanpa Laminasi']);
        if (!$product->laminations->contains($tanpaLaminasi->id)) {
            $product->laminations()->attach($tanpaLaminasi->id, ['additional_price' => 0]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        $product->materials()->detach();
        $product->sizes()->detach();
        $product->laminations()->detach();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
