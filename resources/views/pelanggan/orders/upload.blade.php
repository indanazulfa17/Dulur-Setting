@extends('layouts.pelanggan')
@section('title', 'Upload Bukti Pembayaran')

@section('content')

{{-- Header --}}
<header>
  <h2>Konfirmasi Pembayaran</h2>
  <div class="desc" style="margin-top: 24px; color: white">Selesaikan Pembayaran Anda</div>
</header>
<div class="container py-5">
    {{-- Breadcrumb --}}
    <a href="{{ route('pelanggan.products.show', [
        'id' => $order->product->id,
        'material_id' => $order->material_id,
        'size_id' => $order->size_id,
        'lamination_id' => $order->lamination_id,
        'quantity' => $order->quantity,
        'custom_description' => $order->custom_description,
    ]) }}" class="breadcrumb-back-link mb-3 d-inline-block">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Pesanan
    </a>

<div class="row shadow-sm bg-white rounded mb-2">

{{-- Kolom Ringkasan --}}
<div class="col-md-6 mb-4">
    <div class="p-4 bg-white">
        <h5 class="sub-heading">Ringkasan Pembayaran</h5>
            <p class="desc">Total Bayar: 
                <strong style="color: #FFA600;">Rp{{ number_format($order->total_price + $order->shipping_cost, 0, ',', '.') }}</strong>
            </p>
    {{-- Instruksi Pembayaran --}}
    <div class="p-4 bg-light">
        <p>Silakan lakukan pembayaran ke rekening bank berikut:</p>
            <div class="mb-3 d-flex align-items-center">
                <img src="{{ asset('images/konfirmasi/bca.jpg') }}" alt="Bank BCA" style="width: 40px;" class="me-3">
                    <div>
                        <p class="mb-1 fw-semibold">Bank BCA</p>
                        <p class="mb-0">No.Rek : 1483165122 (a.n. Mulyadi Mian)</p>
                    </div>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <img src="{{ asset('images/konfirmasi/BSI.png') }}" alt="BSI" style="width: 40px;" class="me-3">
                    <div>
                        <p class="mb-1 fw-semibold">Bank BSI</p>
                        <p class="mb-0">No.Rek : 711.8108.226 (a.n. Mulyadi Mian)</p>
                    </div>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <img src="{{ asset('images/konfirmasi/BRI.png') }}" alt="BRI" style="width: 40px;" class="me-3">
                    <div>
                        <p class="mb-1 fw-semibold">Bank BRI</p>
                        <p class="mb-0">No.Rek : 417101014439531 (a.n. Mulyadi Mian)</p>
                    </div>
            </div>   
    </div>
    </div>
</div>

{{-- Kolom Pembayaran --}}
<div class="col-md-6 mb-4">
    <form id="formKonfirmasi" action="{{ route('order.uploadPaymentProof', $order->id)
        }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Upload Bukti Pembayaran --}}
                <div class="px-4 mb-3">
                    <p >
                        Silahkan upload bukti pembayaran disini. Pesanan hanya akan diproses setelah pembayaran dikonfirmasi.
                    </p>
                    <label for="payment_proof" class="form-label">Upload Bukti Pembayaran<span class="text-danger">*</span></label>
                    <input type="file" name="payment_proof" id="payment_proof" class="form-control @error('payment_proof') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf" required>
                    @error('payment_proof')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Konfirmasi --}}
                <div class="text-center px-4">
                    <button type="button" class="btn btn-md btn-primary mt-3 w-100" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                        Konfirmasi
                    </button>
                </div>

                <!-- Modal Konfirmasi -->
                <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content custom-modal">
                            <div class="modal-body text-center">
                                <p>Apakah kamu yakin ingin konfirmasi pembayaran ini ?</p>
                            </div>
                            <div class="modal-footer justify-content-center border-0">
                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batalkan</button>
                                <button type="submit" class="btn btn-simpan" form="formKonfirmasi">Konfirmasi</button>
                            </div>
                        </div>
                    </div>
                </div>
    </form>
</div>

</div>
</div>

@endsection

@section('scripts')
<script>
    // Optional: prevent double submit
    document.getElementById('formKonfirmasi').addEventListener('submit', function(){
        const submitButtons = this.querySelectorAll('button[type="submit"]');
        submitButtons.forEach(btn => btn.disabled = true);
    });
</script>
@endsection
