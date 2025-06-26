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

    // Menampilkan detail pesanan
    public function show(Order $order)
    {
        // Load relasi supaya bisa diakses di blade
        $order->load(['product', 'material', 'size', 'lamination']);

        return view('admin.orders.show', compact('order'));
    }

    // Menampilkan riwayat semua pesanan
    public function history()
    {
        $orders = Order::with(['product', 'size', 'material', 'lamination'])->latest()->get();
        return view('admin.riwayat-pesan', compact('orders'));
    }

    // Mengupdate status dan pembayaran pesanan
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

    // Menghapus pesanan
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Pesanan berhasil dihapus.');
    }
}
