@extends('layouts.pelanggan')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="container mt-5">

    
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('pelanggan.beranda') }}">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('pelanggan.products.show', $order->product->id) }}"> Produk
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"> Konfirmasi </li>
        </ol>
    </nav>

    <h4 class="mb-4 text-center">Konfirmasi Pesanan</h4>

    <div class="row">
        {{-- Ringkasan pesanan --}}
<div class="col-md-6">
    <div class="form-pemesanan">
        <h5 class="mb-4">
            <i class="bi bi-receipt-cutoff me-2 text-primary"></i>
            <strong>Ringkasan Pesanan</strong>
        </h5>

        {{-- Gambar Produk --}}
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . ($order->product->mainImage->image_path ?? 'default.jpg')) }}"
                 alt="{{ $order->product->name }}"
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 160px; object-fit: contain;">
        </div>

        {{-- Info Produk --}}
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Produk</span>
                <span><strong>{{ $order->product->name }}</strong></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Jumlah</span>
                <span>{{ $order->quantity }}</span>
            </div>
            @if (!empty($order->size))
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Ukuran</span>
                <span>
                    {{ $order->size->name ?? '-' }}
                    @if (!empty($order->size->dimension))
                        ({{ $order->size->dimension }})
                    @endif
                </span>
            </div>
            @endif
            @if (!empty($order->material))
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Bahan</span>
                <span>{{ $order->material->name ?? '-' }}</span>
            </div>
            @endif
            @if (!empty($order->lamination))
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Laminasi</span>
                <span>{{ $order->lamination->name ?? '-' }}</span>
            </div>
            @endif

            {{-- Dynamic Fields --}}
            @if (!empty($order->dynamic_fields))
                @foreach ($order->dynamic_fields as $fieldName => $value)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ ucfirst(str_replace('_', ' ', $fieldName)) }}</span>
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
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Deskripsi</span>
                <span>{{ $order->custom_description }}</span>
            </div>
            @endif
        </div>

        <hr>

        <div class="d-flex justify-content-between mb-3">
            <strong>Total Harga</strong>
            <strong class="text-primary">Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
        </div>

        <p class="text-center text-muted mb-0">Pastikan data pesanan sudah sesuai</p>
    </div>
</div>


        {{-- Form konfirmasi --}}
        <div class="col-md-6">
            <div class="form-pemesanan">
                <form action="{{ route('order.finalize', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-confirm">
                        <label for="customer_name" class="form-label">Nama Pemesan<span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                    </div>

                    <div class="form-confirm">
                        <label for="whatsapp" class="form-label">No. WhatsApp<span class="text-danger">*</span></label>
                        <input type="text" name="whatsapp" id="whatsapp" class="form-control" placeholder="Masukkan No. Whatsapp" required>
                    </div>

                    <div class="form-confirm">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email Anda">
                    </div>

                    <div class="form-confirm">
                        <label for="shipping_method" class="form-label">Metode Pengambilan<span class="text-danger">*</span></label>
                        <select name="shipping_method" id="shipping_method" class="form-control" required>
                            <option value="">-- Pilih Metode Pengambilan--</option>
                            <option value="ambil">Ambil di tempat</option>
                            <option value="kirim">Dikirim</option>
                        </select>
                    </div>

                    <div class="form-confirm" id="alamatContainer" style="display: none;">
                        <label for="shipping_address" class="form-label">Alamat Pengiriman<span class="text-danger">*</span></label>
                        <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" placeholder="Masukkan Alamat Lengkap Pengiriman"></textarea>
                    </div>

                    <div class="payment mt-4 p-4 ">
    <h5 class="judul"><i class="bi bi-credit-card"></i> Instruksi Pembayaran</h5>
    <p>Silakan lakukan pembayaran ke rekening berikut:</p>

    <div class="mb-3 d-flex align-items-center">
        <img src="{{ asset('images/konfirmasi/bca.jpg') }}" alt="Bank BCA" style="width: 40px; height: auto;" class="me-3">
        <div>
            <p style="margin-bottom: 2px; font-weight: 600">Bank BCA</p>
            <p style="margin-bottom: 2px;">No.Rek: 1234567890 (a.n. Mulyadi Mian)</p>
        </div>
    </div>

    <div class="mb-3 d-flex align-items-center">
        <img src="{{ asset('images/konfirmasi/dana.png') }}" alt="DANA" style="width: 40px; height: auto;" class="me-3">
        <div>
            <p style="margin-bottom: 2px; font-weight: 600">DANA</p>
            <p style="margin-bottom: 2px;">No: 0812-3456-7890 (a.n. Mulyadi Mian)</p>
        </div>
    </div>

    <div class="mb-3 d-flex align-items-center">
        <img src="{{ asset('images/konfirmasi/ovo.png') }}" alt="OVO" style="width: 40px; height: auto;" class="me-3">
        <div>
            <p style="margin-bottom: 2px; font-weight: 600">OVO</p>
            <p style="margin-bottom: 2px;">No: 0812-9876-5432 (a.n. Mulyadi Mian)</p>
        </div>
    </div>

    <p class="mb-0 mt-3">Setelah transfer, Anda bisa unggah bukti pembayaran di bawah ini atau kirimkan lewat WhatsApp kami.</p>
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
