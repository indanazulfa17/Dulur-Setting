<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        // Riwayat Pesanan: status selesai & dibatalkan
        $orders = Order::with(['product', 'size', 'material', 'lamination'])
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function newOrders()
    {
        // Pesanan baru: status menunggu & diproses
        $newOrders = Order::with(['product', 'size', 'material', 'lamination'])
            ->whereIn('status', ['menunggu', 'diproses'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.new', compact('newOrders'));
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
        $orders = Order::with(['product', 'size', 'material', 'lamination'])
            ->where('status', '!=', 'draft') // hanya status bukan draft
            ->latest()
            ->get();

        return view('admin.riwayat-pesan', compact('orders'));
    }

    // Mengupdate status dan pembayaran pesanan
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'nullable|in:menunggu,diproses,selesai,dibatalkan',
            'payment_status' => 'nullable|in:belum,menunggu_verifikasi,sudah',
        ]);

        $order->update(array_filter([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]));

        // Kirim WA jika ada status baru dan nomor WA
        if ($request->status && $order->whatsapp) {
            $message = "Halo, pesanan Anda untuk produk *{$order->product->name}* kini berstatus: *" . ucfirst($order->status) . "*.";

            if (strtolower($order->status) === 'menunggu') {
    $message .= "\n\nSilakan segera upload bukti pembayaran melalui website atau kirimkan ke WhatsApp kami.";
}

$message .= "\n\nTerima kasih telah memesan di Dulur Setting!";

            $this->sendWhatsappWablas($order->whatsapp, $message);
        }

        return redirect()->back()->with('success', 'Status pesanan diperbarui & pesan WA dikirim.');
    }

    protected function sendWhatsappWablas($phone, $message)
    {
        $server = env('WABLAS_SERVER', 'bdg'); 
        $token = env('WABLAS_TOKEN');

        $phone = preg_replace('/[^0-9]/', '', $phone); 

        $response = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ])->post("https://{$server}.wablas.com/api/send-message", [
            'phone' => $phone,
            'message' => $message,
            'secret' => false,
            'priority' => false,
        ]);

        if ($response->failed()) {
            Log::error("Gagal kirim WA ke $phone: " . $response->body());
        }
    }

    public function sendWhatsapp(Order $order)
{
    if (!$order->whatsapp) {
        return redirect()->back()->with('error', 'Nomor WhatsApp tidak tersedia.');
    }

    $message = "Halo, pesanan Anda untuk produk *{$order->product->name}* saat ini berstatus: *" . ucfirst($order->status) . "*.";

if (strtolower($order->status) === 'menunggu') {
    $message .= "\n\nSilakan segera upload bukti pembayaran melalui website atau kirimkan ke WhatsApp kami.";
}

$message .= "\n\nTerima kasih telah memesan di Dulur Setting!";


    $this->sendWhatsappWablas($order->whatsapp, $message);

    return redirect()->back()->with('success', 'Pesan WhatsApp berhasil dikirim.');
}

    // Menghapus pesanan
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Pesanan berhasil dihapus.');
    }
}
