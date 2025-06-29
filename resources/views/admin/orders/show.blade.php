@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid mt-5">
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-back-link mb-3 d-inline-block">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
    </a>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fa-solid fa-receipt me-2 text-primary"></i>
                Detail Pesanan
            </h5>
        </div>

        <div class="card-body">

            {{-- INFORMASI PELANGGAN --}}
            <section class="mb-4">
                <h6 class="fw-semibold text-uppercase text-muted mb-3">
                    <i class="fa-solid fa-user me-2"></i>Informasi Pelanggan
                </h6>
                <div class="row">
                    <div class="col-md-4 mb-2"><strong>Nama:</strong> {{ $order->customer_name }}</div>
                    <div class="col-md-4 mb-2"><strong>WhatsApp:</strong> {{ $order->whatsapp }}</div>
                    <div class="col-md-4 mb-2"><strong>Email:</strong> {{ $order->email ?? '-' }}</div>
                </div>
            </section>

            {{-- DETAIL PESANAN --}}
            <section class="mb-4">
                <h6 class="fw-semibold text-uppercase text-muted mb-3">
                    <i class="fa-solid fa-box-open me-2"></i>Detail Pesanan
                </h6>
                <div class="row">
                    <div class="col-md-4 mb-2"><strong>Produk:</strong> {{ $order->product->name ?? '-' }}</div>
                    <div class="col-md-4 mb-2"><strong>Bahan:</strong> {{ $order->material->name ?? '-' }}</div>
                    <div class="col-md-4 mb-2"><strong>Ukuran:</strong> {{ $order->size->name ?? '-' }}</div>
                    <div class="col-md-4 mb-2"><strong>Laminasi:</strong> {{ $order->lamination->name ?? '-' }}</div>

                    @php
                        // Ambil mapping dari 'name' ke 'label' dari JSON form_fields
                        $fieldLabels = collect(json_decode($order->product->form_fields, true) ?? [])
                            ->mapWithKeys(fn($field) => [$field['name'] => $field['label']])
                            ->toArray();
                    @endphp

                    @if (!empty($order->dynamic_fields) && is_array($order->dynamic_fields))
                        @foreach ($order->dynamic_fields as $key => $value)
                            <div class="col-md-4 mb-2">
                                <strong>{{ $fieldLabels[$key] ?? str_replace('_', ' ', ucfirst($key)) }}:</strong>
                                @if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL))
                                    <a href="{{ $value }}" target="_blank">{{ $value }}</a>
                                @elseif (is_string($value) && (str_starts_with($value, 'uploads/') || str_starts_with($value, 'products/')))
                                    <a href="{{ asset('storage/' . $value) }}" target="_blank">Lihat File</a>
                                @else
                                    {{ $value ?: '-' }}
                                @endif
                            </div>
                        @endforeach
                    @endif

                    <div class="col-md-4 mb-2"><strong>Jumlah:</strong> {{ $order->quantity }}</div>
                    <div class="col-md-4 mb-2">
                        <strong>Total Harga:</strong>
                        <span class="badge bg-success">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($order->custom_description)
                    <div class="mt-3">
                        <strong>Deskripsi Tambahan:</strong><br>
                        <div class="border rounded bg-light p-2">{{ $order->custom_description }}</div>
                    </div>
                @endif
            </section>

            {{-- PENGAMBILAN --}}
            <section class="mb-4">
                <h6 class="fw-semibold text-uppercase text-muted mb-3">
                    <i class="fa-solid fa-truck me-2"></i>Metode Pengambilan
                </h6>
                <p><strong>Metode:</strong> {{ ucfirst($order->shipping_method) }}</p>
                @if($order->shipping_method === 'kirim')
                    <p><strong>Alamat Pengiriman:</strong><br>{{ $order->shipping_address }}</p>
                @endif
            </section>

            {{-- DESAIN --}}
            <section class="mb-4">
                <h6 class="fw-semibold text-uppercase text-muted mb-3">
                    <i class="fa-solid fa-paintbrush me-2"></i>Desain
                </h6>
                @if ($order->design_file)
                    <div class="mb-2">
                        <strong>File Upload:</strong><br>
                        <a href="{{ asset('storage/' . $order->design_file) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->design_file) }}" alt="Desain" class="img-thumbnail" style="max-width: 200px;">
                        </a>
                    </div>
                @endif

                @if ($order->design_link)
                    <p><strong>Link Desain:</strong> 
                        <a href="{{ $order->design_link }}" target="_blank">{{ $order->design_link }}</a>
                    </p>
                @endif

                @if (!$order->design_file && !$order->design_link)
                    <p class="text-muted">Tidak ada file atau link desain tersedia.</p>
                @endif
            </section>

            {{-- BUKTI PEMBAYARAN --}}
            @if($order->payment_proof)
                <section class="mb-3">
                    <h6 class="fw-semibold text-uppercase text-muted mb-3">
                        <i class="fa-solid fa-money-check-dollar me-2"></i>Bukti Pembayaran
                    </h6>
                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded shadow-sm" style="max-width: 300px;">
                    </a>
                </section>
            @endif

        </div>
    </div>
</div>
@endsection
