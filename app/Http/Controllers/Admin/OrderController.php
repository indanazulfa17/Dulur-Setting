<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $orders = Order::with(['product', 'size', 'material', 'lamination'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan sesuai yang kamu minta
    public function show(Order $order)
    {
        // Pastikan relasi di-load biar di blade bisa dipakai
        $order->load(['product', 'material', 'size', 'lamination']);

        // Tampilkan view yang sudah kamu buat: admin.pesanan (resources/views/admin/pesanan.blade.php)
        return view('admin.pesanan', compact('order'));
    }

    // Menampilkan riwayat semua pesanan untuk admin
public function history()
{
    $orders = Order::with(['product', 'size', 'material', 'lamination'])->latest()->get();
    return view('admin.riwayat-pesan', compact('orders'));
}

    public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'nullable|in:diproses,selesai',
        'payment_status' => 'nullable|in:belum,menunggu_verifikasi,diterima,ditolak',
    ]);

    $order->update(array_filter([
        'status' => $request->status,
        'payment_status' => $request->payment_status,
    ]));

    return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
}

}
