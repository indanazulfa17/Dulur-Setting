@extends('layouts.pelanggan')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center">
        {{-- Ilustrasi sukses --}}
        <img src="{{ asset('images/order-confirmed.svg') }}" alt="Pesanan Berhasil" class="mb-4" style="max-width: 180px;">

        <h4 class="success">Pesanan Berhasil Dikonfirmasi</h4>
        
        <p class="lead mb-1" style="color :#343F52">Terima kasih, <strong>{{ $order->customer_name }}</strong>!</p>
        <p class="desc">Pesanan kamu sedang kami proses. Kami akan menghubungi kamu lewat WhatsApp di nomor <strong>{{ $order->whatsapp }}</strong>.</p>
        
        <a href="{{ route('pelanggan.beranda') }}" class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
