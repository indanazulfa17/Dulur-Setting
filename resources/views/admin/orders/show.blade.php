@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

{{-- BREADCRUMB --}}
<a href="{{ route('admin.orders.index') }}" class="breadcrumb-back-link mb-3 d-inline-block">
    <i class="fas fa-arrow-left me-1"></i> Kembali ke Pesanan
</a>

 {{-- PESANAN SECTION --}}
<div class="card shadow-none border-0">
    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center" style="border-radius: 12px; overflow: hidden;">
        <h5 class="heading mb-0">Detail Pesanan</h5>
    </div>
    <div class="card-body bg-light">

        {{-- INFORMASI PELANGGAN --}}
        <section class="mb-4 p-3 rounded shadow-sm bg-white">
            <div class="pesanan-head mb-3"> Informasi Pelanggan </div>
            <dl class="row mb-0">
                <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Nama</dt>
                <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->customer_name }}</dd>

                <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">WhatsApp</dt>
                <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->whatsapp }}</dd>

                <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Email</dt>
                <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->email ?? '-' }}</dd>
            </dl>
        </section>

        {{-- DETAIL PESANAN --}}
        <section class="mb-4 p-3 rounded shadow-sm bg-white">
            <div class="pesanan-head mb-3">Detail Pesanan</div>
            <dl class="row mb-0">
                <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Produk</dt>
                <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->product->name ?? '-' }}</dd>

                @if ($order->material_id)
    <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Bahan</dt>
    <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->material->name }}</dd>
@endif


                @if ($order->size_id)
    <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Ukuran</dt>
    <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->size->name }}</dd>
@endif


                <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Laminasi</dt>
                <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->lamination->name ?? '-' }}</dd>

                @php        
                $fieldLabels = collect(json_decode($order->product->form_fields, true) ?? [])
                    ->mapWithKeys(fn($field) => [$field['name'] => $field['label']])
                    ->toArray();
                @endphp

                    @if (!empty($order->dynamic_fields) && is_array($order->dynamic_fields))
                        @foreach ($order->dynamic_fields as $key => $value)
                            <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">{{ $fieldLabels[$key] ?? str_replace('_', ' ', ucfirst($key)) }}</dt>
                            <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">
                                @if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL))
                                    <a href="{{ $value }}" target="_blank">{{ $value }}</a>
                                @elseif (is_string($value) && (str_starts_with($value, 'uploads/') || str_starts_with($value, 'products/')))
                                    <a href="{{ asset('storage/' . $value) }}" target="_blank">Lihat File</a>
                                @else
                                    {{ $value ?: '-' }}
                                @endif
                            </dd>
                        @endforeach
                    @endif

                <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Jumlah</dt>
                <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->quantity }}</dd>

                <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Total Harga</dt>
                <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">
                    <span class="" style="font-family: 'Inter', sans-serif; color: #FFA500; font-weight: 600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                </dd>

                @if($order->custom_description)
                    <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Deskripsi Tambahan</dt>
                    <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">
                        {{ $order->custom_description }}
                    </dd>
                @endif
            </dl>
        </section>
        

        {{-- PENGAMBILAN --}}
        <section class="mb-4 p-3 rounded shadow-sm bg-white">
            <div class="pesanan-head mb-3">Metode Pengambilan</div>
            <dl class="row mb-0">
                <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Metode</dt>
                <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ ucfirst($order->shipping_method) }}</dd>

                @if($order->shipping_method === 'kirim')
                    <dt class="col-sm-3" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Alamat Pengiriman</dt>
                    <dd class="col-sm-9" style="font-family: 'Inter', sans-serif; color: #60697B;">{{ $order->shipping_address }}</dd>
                @endif
            </dl>
        </section>

        {{-- DESAIN --}}
        <section class="mb-4 p-3 rounded shadow-sm bg-white">
    <div class="pesanan-head mb-3">Desain</div>

    @if ($order->design_file)
        <div class="mb-2">
            <div class="mb-2" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">File Upload :</div>
            <div class="img-hover-wrapper" style="position: relative; display: inline-block;">
                <a href="{{ asset('storage/' . $order->design_file) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->design_file) }}" alt="Desain" class="img-fluid" style="max-width: 300px;">
                    <div class="lihat-gambar-overlay">Lihat Gambar</div>
                </a>
            </div>
        </div>
    @endif

    @if ($order->design_link)
        <div class="mb-2" style="font-family: 'Inter', sans-serif; color: #343F52; font-weight: 500">Link Desain :</div> 
        <a href="{{ $order->design_link }}" target="_blank">{{ $order->design_link }}</a>
    @endif

    @if (!$order->design_file && !$order->design_link)
        <p class="text-muted">Tidak ada file atau link desain tersedia.</p>
    @endif
</section>


        {{-- BUKTI PEMBAYARAN --}}
        @if($order->payment_proof)
            <section class="mb-3 p-3 rounded shadow-sm bg-white">
    <div class="pesanan-head mb-3">Bukti Pembayaran</div>
    <div class="img-hover-wrapper" style="position: relative; display: inline-block;">
        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid" style="max-width: 300px;">
            <div class="lihat-gambar-overlay">Lihat Gambar</div>
        </a>
    </div>
</section>
        @endif

@if (!in_array($order->status, ['selesai', 'dibatalkan']))
    <section class="mt-4 p-3 rounded shadow-sm bg-white">
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="status" class="form-label">Ubah Status Pesanan</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="diproses">Diproses</option>
                    <option value="dibatalkan">Dibatalkan</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            @php
    $waMessage = "Halo, pesanan Anda untuk produk *" . ($order->product->name ?? '-') . "* saat ini berstatus: *" . ucfirst($order->status) . "*.";

    if (!$order->payment_proof) {
        $waMessage .= "\n\nTotal pesanan Anda *Rp" . number_format($order->total_price, 0, ',', '.') . "*. Silakan lakukan pembayaran dan upload bukti pembayaran.";
    }

    $waMessage .= "\n\nTerima kasih telah memesan di Dulur Setting!";

    $waLink = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $order->whatsapp) . '?text=' . urlencode($waMessage);
@endphp

<div class="d-flex justify-content-between flex-wrap gap-2 mt-4">
    <a href="{{ $waLink }}" target="_blank" class="btn btn-whatsapp btn-md">
        <i class="fab fa-whatsapp me-1"></i> Kirim Status via WhatsApp
    </a>
    <button type="submit" class="btn btn-primary btn-md">
        Simpan Perubahan
    </button>
</div>

        </form>
    </section>
@endif


    </div>
</div>

@endsection
