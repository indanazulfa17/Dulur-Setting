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
    // Tahap 1: Simpan pesanan awal (tanpa nama/wa)
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
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $total = $product->price;

        if ($validated['material_id']) {
            $total += Material::find($validated['material_id'])->extra_price ?? 0;
        }
        if ($validated['size_id']) {
            $total += Size::find($validated['size_id'])->extra_price ?? 0;
        }
        if ($validated['lamination_id']) {
            $total += Lamination::find($validated['lamination_id'])->extra_price ?? 0;
        }

        $totalPrice = $total * $validated['quantity'];

        $order = new Order($validated);
        $order->total_price = $totalPrice;

        if ($request->hasFile('design_file')) {
            $order->design_file = $request->file('design_file')->store('designs', 'public');
        }

        $order->status = 'draft';
        $order->save();

        return redirect()->route('order.confirmation', $order->id);
    }

    // Halaman konfirmasi (isi nama, wa, metode kirim, bukti bayar)
    public function showConfirmation($id)
    {
        $order = Order::findOrFail($id);
        return view('pelanggan.orders.confirmation', compact('order'));
    }

    // Finalisasi pesanan
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
        $order->customer_name = $validated['customer_name'];
        $order->whatsapp = $validated['whatsapp'];
        $order->email = $validated['email'] ?? null;
        $order->shipping_method = $validated['shipping_method'];
        $order->shipping_address = $validated['shipping_method'] === 'kirim' ? $validated['shipping_address'] : null;

        if ($request->hasFile('payment_proof')) {
            $order->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public');
            $order->payment_status = 'menunggu_verifikasi';
        } else {
            $order->payment_status = 'belum';
        }

        $order->status = 'diproses';
        $order->save();

        return redirect()->route('order.success', ['id' => $order->id]);
    }

    // (Optional) Upload ulang bukti pembayaran
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

    // Halaman sukses setelah finalisasi pesanan
public function successPage($id)
{
    $order = Order::findOrFail($id);
    return view('pelanggan.orders.success', compact('order'));
}

}
