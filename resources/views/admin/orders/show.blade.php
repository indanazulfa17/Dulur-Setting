@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid px-4 pt-4">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Detail Pesanan #{{ $order->id }}</h4>
        </div>

        <div class="card-body">
            <h5>Informasi Pelanggan</h5>
            <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
            <p><strong>WhatsApp:</strong> {{ $order->whatsapp }}</p>
            <p><strong>Email:</strong> {{ $order->email ?? '-' }}</p>

            <hr>

            <h5>Detail Pesanan</h5>
            <p><strong>Produk:</strong> {{ $order->product->name ?? '-' }}</p>
            <p><strong>Bahan:</strong> {{ $order->material->name ?? '-' }}</p>
            <p><strong>Ukuran:</strong> {{ $order->size->name ?? '-' }}</p>
            <p><strong>Laminasi:</strong> {{ $order->lamination->name ?? '-' }}</p>
            <p><strong>Jumlah:</strong> {{ $order->quantity }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>

            @if($order->custom_description)
                <p><strong>Deskripsi Tambahan:</strong><br>{{ $order->custom_description }}</p>
            @endif

            {{-- ✅ Menampilkan dynamic_fields (form_fields dari pelanggan) --}}
            @if (!empty($order->dynamic_fields) && is_array($order->dynamic_fields))
                <hr>
                <h5>Input Tambahan dari Pelanggan</h5>
                <ul class="list-group mb-3">
                    @foreach ($order->dynamic_fields as $key => $value)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="fw-semibold">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                            <div class="text-end">
                                @if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL))
                                    <a href="{{ $value }}" target="_blank">{{ $value }}</a>
                                @elseif (is_string($value) && (str_starts_with($value, 'uploads/') || str_starts_with($value, 'products/')))
                                    <a href="{{ asset('storage/' . $value) }}" target="_blank">Lihat File</a>
                                @else
                                    {{ $value }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <hr>

            <h5>Metode Pengambilan</h5>
            <p><strong>Metode:</strong> {{ ucfirst($order->shipping_method) }}</p>
            @if($order->shipping_method === 'kirim')
                <p><strong>Alamat Pengiriman:</strong><br>{{ $order->shipping_address }}</p>
            @endif

            <hr>

            <h5>Desain</h5>
            @if ($order->design_file)
                <p><strong>File Upload:</strong></p>
                <a href="{{ asset('storage/' . $order->design_file) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->design_file) }}" alt="Desain" style="max-width: 200px;">
                </a>
            @endif

            @if ($order->design_link)
                <p><strong>Link Desain:</strong> 
                    <a href="{{ $order->design_link }}" target="_blank">{{ $order->design_link }}</a>
                </p>
            @endif

            @if (!$order->design_file && !$order->design_link)
                <p>Tidak ada file atau link desain tersedia.</p>
            @endif

            @if($order->payment_proof)
                <hr>
                <h5 class="mt-4">Bukti Pembayaran</h5>
                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid" style="max-width: 300px;">
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
