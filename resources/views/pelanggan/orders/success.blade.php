@extends('layouts.pelanggan')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center p-5 shadow-sm rounded" style="background-color: #fff; max-width: 700px; width: 100%;">
        <img src="{{ asset('images/order-confirmed.svg') }}" alt="Pesanan Berhasil" class="mb-4" style="max-width: 180px;">
            <h4 class="sub-heading text-center" style="color: #FFA600">Pesanan Berhasil Dikonfirmasi</h4>
            <p class="mb-1" style="color:#343F52">Terima kasih, <strong>{{ $order->customer_name }}</strong>!</p>
            <p class="desc text-muted">Pesanan kamu sedang kami proses. Kami akan menghubungi kamu lewat WhatsApp di <strong>{{ $order->whatsapp }}</strong>.</p>
        <a href="{{ route('pelanggan.beranda') }}" class="btn btn-primary px-4 py-2 ">
            Kembali ke Beranda
        </a>
        <p class="mt-4 small text-muted">
            Butuh bantuan? <a href="https://wa.me/62{{ ltrim($order->whatsapp, '0') }}" style="color:#005FCA;">Hubungi kami via WhatsApp</a>
        </p>
    </div>
</div>
@endsection
