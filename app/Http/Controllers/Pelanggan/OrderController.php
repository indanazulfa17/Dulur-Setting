<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Material;
use App\Models\Size;
use App\Models\Lamination;

class OrderController extends Controller
{
    /**
     * Tahap 1: Simpan pesanan awal
     */
    public function preStore(Request $request)
    {
        $validated = $request->validate([
            'product_id'         => 'required|exists:products,id',
            'material_id'        => 'nullable|exists:materials,id',
            'size_id'            => 'nullable|exists:sizes,id',
            'lamination_id'      => 'nullable|exists:laminations,id',
            'quantity'           => 'required|integer|min:1',
            'custom_description' => 'nullable|string',
            'design_file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'design_link'        => 'nullable|url',
            'form_fields'        => 'nullable|array',
        ]);

        // Validasi minimal salah satu desain
        if (!$request->hasFile('design_file') && empty($validated['design_link'])) {
            return back()->withErrors(['design_file' => 'Harap unggah file desain atau isi link desain.'])->withInput();
        }

        $product = Product::findOrFail($validated['product_id']);
        $total = $product->base_price;

        // Tambahan harga material
        if (!empty($validated['material_id'])) {
            $material = $product->materials()->where('materials.id', $validated['material_id'])->first();
            $total += $material?->pivot->additional_price ?? 0;
        }

        // Tambahan harga ukuran
        if (!empty($validated['size_id'])) {
            $size = $product->sizes()->where('sizes.id', $validated['size_id'])->first();
            $total += $size?->pivot->additional_price ?? 0;
        }

        // Tambahan harga material
        if (!empty($validated['lamination_id'])) {
            $lamination = $product->laminations()->where('laminations.id', $validated['lamination_id'])->first();
            $total += $lamination?->pivot->additional_price ?? 0;
        }

        $totalPrice = $total * $validated['quantity'];

        // Simpan pesanan
        $order = new Order($validated);
        $order->total_price = $totalPrice;
        $order->status = 'draft';

        // Upload desain jika ada
        if ($request->hasFile('design_file')) {
            $order->design_file = $request->file('design_file')->store('designs', 'public');
        }

        if (!empty($validated['design_link'])) {
            $order->design_link = $validated['design_link'];
        }

        // ✅ Simpan dynamic form fields sebagai array (dengan cast otomatis)
        if ($request->filled('form_fields')) {
            $order->dynamic_fields = $request->input('form_fields');
        }

        $order->save();

        return redirect()->route('order.confirmation', $order->id);
    }

    /**
     * Halaman konfirmasi
     */
    public function showConfirmation($id)
    {
        $order = Order::with(['product.mainImage', 'size', 'material', 'lamination'])->findOrFail($id);
        return view('pelanggan.orders.confirmation', compact('order'));
    }

    /**
     * Finalisasi pesanan
     */
    public function finalize(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'whatsapp'         => 'required|string|max:20',
            'email'            => 'nullable|email|max:255',
            'shipping_method'  => 'required|in:ambil,kirim',
            'shipping_address' => 'nullable|string',
            'payment_proof'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $order = Order::findOrFail($id);
        $order->customer_name     = $validated['customer_name'];
        $order->whatsapp          = $validated['whatsapp'];
        $order->email             = $validated['email'] ?? null;
        $order->shipping_method   = $validated['shipping_method'];
        $order->shipping_address  = $validated['shipping_method'] === 'kirim' ? $validated['shipping_address'] : null;
        $order->status            = 'diproses';

        // Upload bukti pembayaran
        if ($request->hasFile('payment_proof')) {
            $order->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public');
            $order->payment_status = 'menunggu_verifikasi';
        } else {
            $order->payment_status = 'belum';
        }

        $order->save();

        return redirect()->route('order.success', $order->id);
    }

    /**
     * Upload ulang bukti pembayaran
     */
    public function uploadPaymentProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $order = Order::findOrFail($id);
        $order->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public');
        $order->payment_status = 'menunggu_verifikasi';
        $order->save();

        return redirect()->route('order.confirmation', $order->id)->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    /**
     * Halaman sukses
     */
    public function successPage($id)
    {
        $order = Order::findOrFail($id);
        return view('pelanggan.orders.success', compact('order'));
    }
}
