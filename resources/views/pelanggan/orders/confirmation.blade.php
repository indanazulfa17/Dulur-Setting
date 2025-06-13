@extends('layouts.pelanggan')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="container mt-5">
    <h4 class="mb-4" style="text-align: center">Konfirmasi Pesanan</h4>

    <div class="row">
        {{-- Ringkasan pesanan --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><strong>Ringkasan Pesanan</strong></div>
                <div class="card-body">
                    <p><strong>Produk:</strong> {{ $order->product->name }}</p>
                    <p><strong>Jumlah:</strong> {{ $order->quantity }}</p>
                    <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Form konfirmasi --}}
        <div class="col-md-6">
            <div class="form-pemesanan">
            <form action="{{ route('order.finalize', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-confirm">
                    <label for="customer_name" class="form-label">Nama Pemesan<span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                </div>

                <div class="form-confirm">
                    <label for="whatsapp" class="form-label">No. WhatsApp<span class="text-danger">*</span></label>
                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" required>
                </div>

                <div class="form-confirm">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>

                <div class="form-confirm">
                    <label for="shipping_method" class="form-label">Metode Pengambilan<span class="text-danger">*</span></label>
                    <select name="shipping_method" id="shipping_method" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="ambil">Ambil di tempat</option>
                        <option value="kirim">Dikirim</option>
                    </select>
                </div>

                <div class="form-confirm" id="alamatContainer" style="display: none;">
                    <label for="shipping_address" class="form-label">Alamat Pengiriman<span class="text-danger">*</span></label>
                    <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-confirm">
                    <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-md btn-primary mt-3 w-100">Konfirmasi Pesanan</button>
                </div>



            </form>
        </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Tampilkan input alamat jika pilih "kirim"
    document.getElementById('shipping_method').addEventListener('change', function() {
        const container = document.getElementById('alamatContainer');
        if (this.value === 'kirim') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    });
</script>
@endsection
