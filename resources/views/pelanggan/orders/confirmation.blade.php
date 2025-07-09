@extends('layouts.pelanggan')

@section('title', 'Konfirmasi Pesanan')

@section('content')


<div class="container py-5">

{{-- Header --}}
<div class="container py-5">
    <h4 class="sub-heading text-center" style="color: #FFA600">Konfirmasi Pesanan</h4>
    <div class="desc text-center">Lengkapi data diri kamu untuk konfirmasi pemesanan </div>
</div>

{{-- Breadcrumb --}}
<div class="breadcrumb-bg mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('pelanggan.beranda') }}"><i class="fa-solid fa-house"></i> Beranda</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('pelanggan.products.show', $order->product->id) }}"> Produk</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"> Konfirmasi</li>
        </ol>
    </nav>
</div>

{{-- Ringkasan pesanan --}}
<div class="row shadow-sm bg-white rounded mb-0">
    <div class="col-md-6">
        <div class="form-pemesanan">
            <h5 class="sub-heading"> Ringkasan Pesanan</h5>

        {{-- Info Produk --}}
        <div class="heading">
            <div class="d-flex justify-content-between mb-2">
                <span class="text" style="color: #343F52; font-weight: 600">Produk</span>
                <span class="text" style="color: #60697B; font-weight: 600">{{ $order->product->name }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text" style="color: #343F52; font-weight: 600">Jumlah</span>
                <span class="text" style="color: #60697B; font-weight: 400">{{ $order->quantity }}</span>
            </div>
            @if (!empty($order->size))
            <div class="d-flex justify-content-between mb-2">
                <span class="text" style="color: #343F52; font-weight: 600">Ukuran</span>
                <span class="text" style="color: #60697B; font-weight: 400">
                    {{ $order->size->name ?? '-' }}
                    @if (!empty($order->size->dimension))
                        ({{ $order->size->dimension }})
                    @endif
                </span>
            </div>
            @endif
            @if (!empty($order->material))
            <div class="d-flex justify-content-between mb-2">
                <span class="text" style="color: #343F52; font-weight: 600">Bahan</span>
                <span class="text" style="color: #60697B; font-weight: 400">{{ $order->material->name ?? '-' }}</span>
            </div>
            @endif
            @if (!empty($order->lamination))
            <div class="d-flex justify-content-between mb-2">
                <span class="text" style="color: #343F52; font-weight: 600">Laminasi</span>
                <span class="text" style="color: #60697B; font-weight: 400">{{ $order->lamination->name ?? '-' }}</span>
            </div>
            @endif

            {{-- Dynamic Fields --}}
            @if (!empty($order->dynamic_fields))
                @foreach ($order->dynamic_fields as $fieldName => $value)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text" style="color: #343F52; font-weight: 600">{{ ucfirst(str_replace('_', ' ', $fieldName)) }}</span>
                        <span class="text" style="color: #60697B; font-weight: 400">
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
                <span class="text" style="color: #343F52; font-weight: 600">Deskripsi</span>
                <span class="text" style="color: #60697B; font-weight: 400">{{ $order->custom_description }}</span>
            </div>
            @endif
        </div>

        {{-- Total Harga --}}
        <div class="d-flex justify-content-between mb-3">
            <div style="color: #FFA600; font-weight:700">Total Harga</div>
            <div style="color: #005FCA; font-weight:700">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
        </div>

        </div>
    </div>

    {{-- Form konfirmasi --}}
    <div class="col-md-6">
        <div class="form-pemesanan">
            <h5 class="sub-heading">Form Konfirmasi</h5>             
                <form id="formKonfirmasi" action="{{ route('order.finalize', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Nama Pemesan --}}
                <div class="form-confirm">
                    <label for="customer_name" class="form-label">Nama Pemesan<span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control @error('customer_name') is-invalid @enderror" placeholder="Masukkan Nama Lengkap" required>    
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Whatsapp --}}
                <div class="form-confirm">
                    <label for="whatsapp" class="form-label">No. WhatsApp<span class="text-danger">*</span></label>
                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" placeholder="Masukkan No. Whatsapp" required>
                    @error('whatsapp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Email --}}
                <div class="form-confirm">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email Anda">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Metode Ambil --}}
                <div class="form-confirm">
                    <label for="shipping_method" class="form-label">Metode Pengambilan<span class="text-danger">*</span></label>
                    <select name="shipping_method" id="shipping_method" class="form-control" required>
                        <option value="">-- Pilih Metode Pengambilan--</option>
                        <option value="ambil">Ambil di tempat</option>
                        <option value="kirim">Dikirim</option>
                    </select>
                </div>
                {{-- Alamat Pengiriman --}}
                <div class="form-confirm" id="alamatContainer" style="display: none;">
                    <label for="shipping_address" class="form-label">Alamat Pengiriman<span class="text-danger">*</span></label>
                    <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" placeholder="Masukkan Alamat Lengkap Pengiriman"></textarea>
                </div>

                {{-- Intruksi Pembayaran --}}
                <div class="payment mt-4 p-4 ">
                    <h5 class="judul" style="font-weight:bold"> Instruksi Pembayaran</h5>
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
                {{-- Upload Bukti (Opsional) --}}
                <div class="form-confirm">
                    <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                {{-- Button Konfirmasi --}}
                <div class="text-center">
                    <button type="button" class="btn btn-md btn-primary mt-3 w-100" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                        Konfirmasi Pesanan
                    </button>
                </div>
                </form>
                
<!-- Modal Konfirmasi Simpan Produk -->
<div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-simpan">
        <i class="bi bi-check-circle-fill"></i> 
      </div>
      <div class="modal-body text-center">
        <h5 class="modal-title mb-3">Konfirmasi Pesanan</h5>
        <p>Apakah kamu yakin ingin konfirmasi pesanan ini?</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batalkan</button>
        <button type="submit" class="btn btn-simpan" id="submitKonfirmasi">Konfirmasi</button>
      </div>
    </div>
  </div>
</div>

            </div>
        </div>
    </div>

<!-- Tombol WhatsApp Sticky dengan Font Awesome -->
<a href="https://wa.me/6285222259229" class="whatsapp-float" target="_blank" title="Hubungi kami via WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Tampilkan alamat jika metode kirim dipilih
    document.getElementById('shipping_method').addEventListener('change', function () {
        const container = document.getElementById('alamatContainer');
        container.style.display = this.value === 'kirim' ? 'block' : 'none';
    });

    // Submit form dari modal
    document.getElementById('submitKonfirmasi').addEventListener('click', function () {
        document.getElementById('formKonfirmasi').submit();
    });
</script>

@endsection
