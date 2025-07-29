@extends('layouts.admin')

@section('title', 'Pesanan Baru')

@section('content')

{{-- BREADCRUMB --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb custom-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Pesanan Baru</li>
    </ol>
</nav>

<h5 class="heading">Pesanan Baru</h5>

@if($newOrders->isEmpty())
    <p class="text-muted">Tidak ada pesanan baru.</p>
@else
<div class="table-responsive">
    <table class="table table-custom-font align-middle table-hover table-borderless shadow-sm rounded" style="border-radius: 12px; overflow: hidden;">
    <thead class="bg-light text-dark">
        <tr>
            <th style>No</th>
            <th style>Nama</th>
            <th style>Produk</th>
            <th style="width: 100px">Jumlah</th>
            <th style="width: 150px">Status</th>
            <th style>Waktu</th>
            <th style="width: 100px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($newOrders as $order)
            <tr>
                <td>{{ $newOrders->firstItem() + $loop->index }}</td>
                <td>{{ $order->customer_name ?? '-' }}</td>
                <td>{{ $order->product->name ?? '-' }}</td>
                <td>{{ $order->quantity }}</td>
                <td>
                    @php
                        $badgeClass = match ($order->status) {
                            'menunggu' => 'bg-menunggu',
                            'diproses' => 'bg-process',
                            default => 'bg-secondary',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                </td>
                <td>{{ $order->created_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}"
                        class="btn btn-tertiary btn-sm" title="Lihat Detail">
                         <i class="fa-regular fa-eye"></i>
                     </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Paginasi -->
<div class="mt-4 d-flex justify-content-center">
    {{ $newOrders->links() }}
</div>
</div>
@endif

@endsection
