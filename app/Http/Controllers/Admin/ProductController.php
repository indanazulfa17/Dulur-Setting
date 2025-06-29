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

            'new_materials.*.name' => 'required|string',
            'new_materials.*.additional_price' => 'nullable|numeric|min:0',

            'new_sizes.*.name' => 'required|string',
            'new_sizes.*.additional_price' => 'nullable|numeric|min:0',

            'new_laminations.*.name' => 'required|string',
            'new_laminations.*.additional_price' => 'nullable|numeric|min:0',
        ]);

        $formFields = $request->form_fields_json ?? null;

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'base_price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'form_fields' => $formFields,
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
                $material = Material::create(['name' => $new['name']]);
                $product->materials()->attach($material->id, [
                    'additional_price' => $new['additional_price'] ?? 0,
                ]);
            }
        }

        // Simpan ukuran baru
        if ($request->filled('new_sizes')) {
            foreach ($request->new_sizes as $new) {
                $size = Size::create([
                    'name' => $new['name'],
                    'dimension' => $new['dimension'] ?? null,
                ]);
                $product->sizes()->attach($size->id, [
                    'additional_price' => $new['additional_price'] ?? 0,
                ]);
            }
        }

        // Simpan laminasi baru
        if ($request->filled('new_laminations')) {
            foreach ($request->new_laminations as $new) {
                $lamination = Lamination::create(['name' => $new['name']]);
                $product->laminations()->attach($lamination->id, [
                    'additional_price' => $new['additional_price'] ?? 0,
                ]);
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
        ]);

        $formFields = $request->form_fields_json ?? null;

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'base_price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'form_fields' => $formFields,
        ]);

        // Hapus gambar jika diminta
        if ($request->has('existing_images')) {
            foreach ($request->existing_images as $imgData) {
                if (!empty($imgData['delete'])) {
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

        // Sinkronisasi bahan
if ($request->has('materials')) {
    $materials = $request->input('materials');
    $syncData = [];

    foreach ($materials as $material) {
        if (isset($material['id'])) {
            // Jika bahan sudah ada (lama), sync berdasarkan ID
            $syncData[$material['id']] = [
                'additional_price' => $material['additional_price'] ?? 0,
            ];
        } else {
            // Bahan baru, buat di tabel materials
            $newMaterial = Material::firstOrCreate([
                'name' => $material['name'],
            ]);
            $syncData[$newMaterial->id] = [
                'additional_price' => $material['additional_price'] ?? 0,
            ];
        }
    }

    // Sinkronisasi data bahan
    $product->materials()->sync($syncData);
}

if ($request->has('sizes')) {
    $sizes = $request->input('sizes');
    $syncData = [];

    foreach ($sizes as $size) {
        if (!empty($size['name'])) {
            $existingSize = Size::firstOrCreate([
                'name' => $size['name'],
                'dimension' => $size['dimension'] ?? null, // optional
            ]);

            $syncData[$existingSize->id] = [
                'additional_price' => $size['additional_price'] ?? 0,
            ];
        }
    }

    $product->sizes()->sync($syncData);
}



if ($request->has('laminations')) {
    $laminations = $request->input('laminations');
    $syncData = [];

    foreach ($laminations as $lamination) {
        if (isset($lamination['name'])) {
            $existingLamination = Lamination::firstOrCreate([
                'name' => $lamination['name'],
            ]);

            $syncData[$existingLamination->id] = [
                'additional_price' => $lamination['additional_price'] ?? 0,
            ];
        }
    }

    $product->laminations()->sync($syncData);

    // Pastikan "Tanpa Laminasi" selalu ada
    $tanpaLaminasi = Lamination::firstOrCreate(['name' => 'Tanpa Laminasi']);
    if (!$product->laminations->contains($tanpaLaminasi->id)) {
        $product->laminations()->attach($tanpaLaminasi->id, ['additional_price' => 0]);
    }
}


        // Update/hapus bahan, ukuran, laminasi (kode sama seperti sebelumnya, tetap dijaga)
        // [Jika diperlukan, bagian ini bisa direfactor ke private function di kemudian hari]

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
