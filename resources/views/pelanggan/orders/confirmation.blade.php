@extends('layouts.pelanggan')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="container mt-5">

    {{-- ✅ Breadcrumb --}}
    <div class="breadcrumb-wrapper px-4 py-2 rounded mb-4 text-center">
        <nav aria-label="breadcrumb" class="breadcrumb-confirmation">
            <ol class="breadcrumb bg-light p-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('pelanggan.products.show', $order->product->id) }}">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Produk
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Konfirmasi</li>
            </ol>
        </nav>
    </div>

    <h4 class="mb-4 text-center">Konfirmasi Pesanan</h4>

    <div class="row">
        {{-- Ringkasan pesanan --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-receipt-cutoff"></i> Ringkasan Pesanan
                </div>
                <div class="card-body bg-light">
                    {{-- Gambar Produk --}}
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . ($order->product->mainImage->image_path ?? 'default.jpg')) }}"
                             alt="{{ $order->product->name }}"
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 150px; object-fit: contain;">
                    </div>

                    {{-- Info Produk --}}
                    <div class="mb-2 d-flex justify-content-between">
                        <span><strong>Produk :</strong></span>
                        <span>{{ $order->product->name }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span><strong>Jumlah :</strong></span>
                        <span>{{ $order->quantity }}</span>
                    </div>
                    @if (!empty($order->size))
                    <div class="mb-2 d-flex justify-content-between">
                        <span><strong>Ukuran :</strong></span>
                        <span>{{ $order->size->name ?? '-' }} ({{ $order->size->dimension ?? '' }})</span>
                    </div>
                    @endif
                    @if (!empty($order->material))
                    <div class="mb-2 d-flex justify-content-between">
                        <span><strong>Bahan :</strong></span>
                        <span>{{ $order->material->name ?? '-' }}</span>
                    </div>
                    @endif
                    @if (!empty($order->lamination))
                    <div class="mb-2 d-flex justify-content-between">
                        <span><strong>Laminasi :</strong></span>
                        <span>{{ $order->lamination->name ?? '-' }}</span>
                    </div>
                    @endif
                    

                    {{-- Dynamic Fields (Tambahan) --}}
                    @if (!empty($order->dynamic_fields))
                        @foreach ($order->dynamic_fields as $fieldName => $value)
                            <div class="mb-2 d-flex justify-content-between">
                                <span><strong>{{ ucfirst(str_replace('_', ' ', $fieldName)) }} :</strong></span>
                                <span>
                                    @if(is_array($value))
                                        {{ implode(', ', $value) }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    @endif
                    @if (!empty($order->custom_description))
                    <div class="mb-2 d-flex justify-content-between">
                        <span><strong>Deskripsi :</strong></span>
                        <span>{{ $order->custom_description }}</span>
                    </div>
                    @endif


                    <hr>

                    <div class="d-flex justify-content-between">
                        <strong>Total Harga:</strong>
                        <strong class="text-success">Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    Pastikan data pesanan sudah sesuai
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

                    <div class="alert alert-info mt-4">
                        <h5 class="mb-2">Instruksi Pembayaran</h5>
                        <p>Silakan lakukan pembayaran ke rekening berikut:</p>

                        <ul>
                            <li><strong>Bank BCA</strong><br>
                                No. Rekening: <strong>1234567890</strong><br>
                                Atas Nama: <strong>CV. Percetakan Jaya</strong>
                            </li>
                            <li class="mt-2"><strong>DANA</strong><br>
                                Nomor: <strong>0812-3456-7890</strong><br>
                                Nama: <strong>Percetakan Jaya</strong>
                            </li>
                            <li class="mt-2"><strong>OVO</strong><br>
                                Nomor: <strong>0812-9876-5432</strong><br>
                                Nama: <strong>Percetakan Jaya</strong>
                            </li>
                        </ul>

                        <p class="mb-0">Setelah transfer, Anda bisa unggah bukti pembayaran di bawah ini atau kirimkan lewat WhatsApp/email.</p>
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
    document.getElementById('shipping_method').addEventListener('change', function () {
        const container = document.getElementById('alamatContainer');
        container.style.display = this.value === 'kirim' ? 'block' : 'none';
    });
</script>
@endsection
