<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Tahap 1: Simpan pesanan awal (preStore)
     */
    public function preStore(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'material_id' => 'nullable|exists:materials,id',
            'size_id' => 'nullable|exists:sizes,id',
            'lamination_id' => 'nullable|exists:laminations,id',
            'quantity' => 'required|integer|min:1',
            'custom_description' => 'nullable|string',
            'design_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'design_link' => 'nullable|url',
            'form_fields' => 'nullable|array',
        ]);

        if (!$request->hasFile('design_file') && empty($validated['design_link'])) {
            return back()->withErrors(['design_file' => 'Harap unggah file desain atau isi link desain.'])->withInput();
        }

        $product = Product::findOrFail($validated['product_id']);
        $total = $product->base_price;

        // Tambahan harga material, size, laminasi
        if (!empty($validated['material_id'])) {
            $material = $product->materials()->where('materials.id', $validated['material_id'])->first();
            $total += $material?->pivot->additional_price ?? 0;
        }

        if (!empty($validated['size_id'])) {
            $size = $product->sizes()->where('sizes.id', $validated['size_id'])->first();
            $total += $size?->pivot->additional_price ?? 0;
        }

        if (!empty($validated['lamination_id'])) {
            $lamination = $product->laminations()->where('laminations.id', $validated['lamination_id'])->first();
            $total += $lamination?->pivot->additional_price ?? 0;
        }

        // Tambahan harga dynamic form_fields
        $extraPrice = 0;
        if (!empty($product->form_fields)) {
            $decoded = json_decode($product->form_fields, true);
            foreach ($decoded as $field) {
                $name = $field['name'];
                if (empty($request->input("form_fields.$name"))) {
                    return back()->withErrors(["form_fields.$name" => "{$field['label']} wajib diisi."])->withInput();
                }
                if ($field['type'] === 'select') {
                    foreach ($field['options'] as $option) {
                        if ($option['label'] == $request->input("form_fields.$name") && isset($option['price'])) {
                            $extraPrice += $option['price'];
                        }
                    }
                }
            }
        }

        $totalPrice = ($total + $extraPrice) * $validated['quantity'];

        $order = new Order($validated);
        $order->total_price = $totalPrice;
        $order->status = 'draft';

        if ($request->hasFile('design_file')) {
            $order->design_file = $request->file('design_file')->store('designs', 'public');
        }

        if (!empty($validated['design_link'])) {
            $order->design_link = $validated['design_link'];
        }

        if ($request->filled('form_fields')) {
            $order->dynamic_fields = $request->input('form_fields');
        }

        $order->save();

        return redirect()->route('order.confirmation', $order->id);
    }

    /**
     * Tahap 2: Halaman konfirmasi
     */
    public function showConfirmation($id)
    {
        $order = Order::with(['product.mainImage', 'size', 'material', 'lamination'])->findOrFail($id);
        return view('pelanggan.orders.confirmation', compact('order'));
    }

    /**
     * Tahap 3: Finalisasi pesanan dan isi data customer
     */
    public function finalize(Request $request, $id)
    {
        // Jika metode ambil, isi otomatis field alamat dengan null sebelum validasi
    if ($request->shipping_method === 'ambil') {
        $request->merge([
            'address_line' => null,
            'district' => null,
            'city' => null,
            'province' => null,
            'postal_code' => null,
            'courier' => null,
            'service' => null,
            'shipping_cost' => 0,
        ]);
    }

    $validated = $request->validate([
        'customer_name'    => 'required|string|max:255',
        'whatsapp'         => ['required', 'regex:/^628[0-9]{8,15}$/'],
        'email'            => 'nullable|email|max:255',
        'shipping_method'  => 'required|in:ambil,kirim',
        'address_line'     => 'nullable|required_if:shipping_method,kirim|string|max:255',
        'district'         => 'nullable|required_if:shipping_method,kirim|string|max:100',
        'city'             => 'nullable|required_if:shipping_method,kirim|string|max:100',
        'province'         => 'nullable|required_if:shipping_method,kirim|string|max:100',
        'postal_code'      => 'nullable|required_if:shipping_method,kirim|string|max:10',
        'courier'          => 'nullable|string',
        'service'          => 'nullable|string',
        'shipping_cost'    => 'nullable|numeric',
    ]);

        $order = Order::findOrFail($id);
        $order->fill([
            'customer_name'   => $validated['customer_name'],
            'whatsapp'        => $validated['whatsapp'],
            'email'           => $validated['email'] ?? null,
            'shipping_method' => $validated['shipping_method'],
            'shipping_cost'   => $validated['shipping_cost'] ?? 0,
        ]);

        if ($validated['shipping_method'] === 'kirim') {
            $order->shipping_address = implode(', ', [
                $validated['address_line'],
                'Kec. ' . $validated['district'],
                $validated['city'],
                $validated['province'],
                $validated['postal_code'],
            ]);
        } else {
            $order->shipping_address = null;
        }

        $order->total_price += $order->shipping_cost;
        $order->status = 'menunggu';
        $order->payment_status = 'belum';
        $order->save();

        return redirect()->route('order.uploadPage', $order->id)
            ->with('success', 'Pesanan berhasil dikonfirmasi! Silakan upload bukti pembayaran jika sudah transfer.');
    }

    /**
     * Tahap 4: Halaman upload bukti pembayaran
     */
    public function uploadPage($id)
    {
        $order = Order::findOrFail($id);
        return view('pelanggan.orders.upload', compact('order'));
    }

    /**
 * Tahap 5: Upload bukti pembayaran (tidak wajib)
 */
public function uploadPaymentProof(Request $request, $id)
{
    $validated = $request->validate([
        'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
    ]);

    $order = Order::findOrFail($id);

    if ($request->hasFile('payment_proof')) {
        $order->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public');
        $order->payment_status = 'menunggu_verifikasi';
    }

    $order->save();

    return redirect()->route('order.successPage', $order->id)
        ->with('success', 'Pesanan berhasil dikonfirmasi. ' . ($request->hasFile('payment_proof') ? 'Bukti pembayaran berhasil diupload.' : 'Anda dapat mengupload bukti pembayaran nanti.'));
}


    /**
     * Halaman sukses
     */
    public function successPage($id)
    {
        $order = Order::findOrFail($id);
        return view('pelanggan.orders.success', compact('order'));
    }

    /**
     * Batalkan pesanan
     */
    public function cancel(Order $order)
    {
        $order->delete();
        return redirect()->route('pelanggan.beranda')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Cek ongkir via API RajaOngkir
     */
    public function cekOngkir(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|numeric',
            'destination' => 'required|numeric',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string',
        ]);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('https://api.rajaongkir.com/starter/cost', [
                'headers' => [
                    'key' => 'JIsmxdvB3ac7743d52b5523aNHxiZpyF',
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => $validated,
            ]);

            $result = json_decode($response->getBody(), true);
            $costs = $result['rajaongkir']['results'][0]['costs'] ?? [];

            if (empty($costs)) {
                return response()->json(['error' => 'Data ongkir tidak ditemukan.'], 404);
            }

            return response()->json(['details' => $costs]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data ongkir.', 'message' => $e->getMessage()], 500);
        }
    }
    /**
 * Ambil semua provinsi dari API RajaOngkir
 */
public function getProvinces()
{
    try {
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://rajaongkir.komerce.id/api/v1/destination/province", [
            'headers' => [
                'key' => 'JIsmxdvB3ac7743d52b5523aNHxiZpyF',
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        // Komerce pakai 'data' bukan 'rajaongkir'
        return response()->json($result['data']);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Gagal mengambil data provinsi',
            'message' => $e->getMessage(),
        ], 500);
    }
}


/**
 * Ambil kota/kabupaten berdasarkan id provinsi
 */
public function getCities($province_id)
{
    try {
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$province_id}", [
            'headers' => [
                'key' => 'JIsmxdvB3ac7743d52b5523aNHxiZpyF',
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        // Komerce pakai 'data' bukan 'rajaongkir'
        return response()->json($result['data']);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Gagal mengambil data kota',
            'message' => $e->getMessage(),
        ], 500);
    }
}


}
