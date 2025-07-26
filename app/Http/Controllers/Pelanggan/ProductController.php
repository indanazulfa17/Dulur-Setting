<?php

namespace App\Http\Controllers\Pelanggan;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan detail produk dan form pemesanan.
     */
    public function show($id, Request $request)
{
    $product = Cache::remember("product.detail.$id", 3600, function() use ($id) {
    return Product::with([
        'category',
        'mainImage',
        'images',
        'materials',
        'sizes',
        'laminations',
    ])->findOrFail($id);
});


    // Ambil dan parsing form_fields dari produk (jika ada)
    $formFields = [];
    if (!empty($product->form_fields)) {
        $decoded = json_decode($product->form_fields, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $formFields = $decoded;
        }
    }

    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(3)
        ->get();

    // Ambil input sebelumnya dari query string (untuk old value)
$previousInput = [
    'material_id' => $request->query('material_id'),
    'size_id' => $request->query('size_id'),
    'lamination_id' => $request->query('lamination_id'),
    'quantity' => $request->query('quantity'),
    'custom_description' => $request->query('custom_description'),
    'design_input_type' => $request->query('design_input_type'),
    'design_link' => $request->query('design_link'),
    'form_fields' => $request->query('form_fields', []),
];


    return view('pelanggan.products.show', compact(
        'product',
        'formFields',
        'relatedProducts',
        'previousInput'
    ));
}


    /**
     * Simpan pemesanan produk.
     */
    public function preorder(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Ambil dan parsing form_fields
    $formFields = [];
    if (!empty($product->form_fields)) {
        $decoded = json_decode($product->form_fields, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $formFields = $decoded;
        }
    }

    $rules = [
        'material_id'        => 'required|exists:materials,id',
        'size_id'            => 'required|exists:sizes,id',
        'lamination_id'      => 'required|exists:laminations,id',
        'quantity'           => 'required|integer|min:1',
        'design_input_type'  => 'required|in:upload,link',
        'custom_description' => 'nullable|string',
    ];

    // Validasi berdasarkan input desain
    if ($request->input('design_input_type') === 'upload') {
        $rules['design_file'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:10240';
    } else {
        $rules['design_link'] = 'required|url';
    }

    // ✅ Validasi form dinamis agar wajib diisi jika muncul
    $dynamicFields = [];
    foreach ($formFields as $field) {
        $name = $field['name'];
        $rules["form_fields.$name"] = 'required|string';
        $dynamicFields[$name] = $request->input("form_fields.$name");
    }

    $validated = $request->validate($rules, [
        'material_id.required' => 'Bahan wajib dipilih.',
        'size_id.required' => 'Ukuran wajib dipilih.',
        'lamination_id.required' => 'Laminasi wajib dipilih.',
        'quantity.required' => 'Jumlah wajib diisi.',
        'quantity.integer' => 'Jumlah harus berupa angka.',
        'quantity.min' => 'Jumlah minimal 1.',
        'design_input_type.required' => 'Metode input desain wajib dipilih.',
        'design_input_type.in' => 'Metode input desain tidak valid.',
        'design_file.required' => 'File desain wajib diunggah.',
        'design_file.file' => 'File desain harus berupa file.',
        'design_file.mimes' => 'File desain harus berupa pdf, jpg, jpeg, atau png.',
        'design_file.max' => 'Ukuran file desain maksimal 10MB.',
        'design_link.required' => 'Link desain wajib diisi.',
        'design_link.url' => 'Format link desain tidak valid.',
    ]);

    // Simpan order
    $order = Order::create([
        'product_id'         => $product->id,
        'material_id'        => $validated['material_id'],
        'size_id'            => $validated['size_id'],
        'lamination_id'      => $validated['lamination_id'],
        'quantity'           => $validated['quantity'],
        'custom_description' => $validated['custom_description'] ?? null,
        'dynamic_fields'     => $dynamicFields,
        'design_file'        => null, 
        'status'             => 'menunggu',
        'payment_status'     => 'belum',
    ]);

    // Upload file jika ada
    if (
        $validated['design_input_type'] === 'upload' &&
        $request->hasFile('design_file')
    ) {
        $path = $request->file('design_file')->store('designs', 'public');
        $order->update(['design_file' => $path]);
    }

    return redirect()->route('pelanggan.beranda')->with('success', 'Pesanan berhasil dikirim!');
}

}
