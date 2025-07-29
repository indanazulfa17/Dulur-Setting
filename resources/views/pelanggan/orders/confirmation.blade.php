@extends('layouts.pelanggan')

@section('title', 'Konfirmasi Pesanan')

@section('content')




{{-- Header --}}
<header>
  <h2>Konfirmasi Pesanan</h2>
  <div class="desc" style="margin-top: 24px; color: white">Lengkapi data diri kamu untuk konfirmasi pemesanan</div>
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
    <i class="fas fa-arrow-left me-1"></i> Kembali ke Produk
</a>

{{-- Ringkasan pesanan --}}
<div class="row shadow-sm bg-white rounded mb-0">
    <div class="col-md-6 order-mb-2">
        <div class="form-pemesanan" style="margin-bottom: 0px">
            <h5 class="sub-heading"> Ringkasan Pesanan</h5>
            <div class=" p-4 border rounded bg-white">

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
        <hr>
        {{-- Total Harga --}}
        <div class="d-flex justify-content-between mb-3">
            <div style="color: #343F52; font-weight:600">Total Harga Produk</div>
            <div style="color: #FFA600; font-weight:700">Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
        </div>
        </div>
        </div>
    </div>

    {{-- Form konfirmasi --}}
    <div class="col-md-6 order-mb-1">
        <div class="form-pemesanan">
            <h5 class="sub-heading">Form Konfirmasi</h5>  
            <div id="formAlert" class="alert alert-danger d-none">
    Field belum diisi semua. Silakan periksa kembali.
</div>           
                <form id="formKonfirmasi" action="{{ route('order.finalize', $order->id) }}" method="POST">


                @csrf
                {{-- Nama Pemesan --}}
                <div class="form-confirm">
                    <label for="customer_name" class="form-label">Nama Pemesan<span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Masukkan Nama Lengkap" required>    
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Whatsapp --}}
                <div class="form-confirm">
                    <label for="whatsapp" class="form-label">No. WhatsApp<span class="text-danger">*</span></label>
                    <input type="text" name="whatsapp" id="whatsapp" class="form-control"
       placeholder="Contoh: 6281234567890" pattern="628[0-9]{8,15}" title="Gunakan format 628xxxxxxxxx"
       required>

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
                <div id="alamatContainer" style="display: none;">
    <div class="form-confirm">
        <label for="address_line" class="form-label">Alamat Lengkap<span class="text-danger">*</span></label>
        <input type="text" name="address_line" id="address_line" class="form-control" placeholder="Contoh: Jl. Merpati No.123" >
    </div>
    <div class="form-confirm">
        <label for="district" class="form-label">Kecamatan<span class="text-danger">*</span></label>
        <input type="text" name="district" id="district" class="form-control" placeholder="Contoh: Pasar Minggu" >
    </div>
    <div class="form-confirm">
        <label for="city" class="form-label">Kota / Kabupaten<span class="text-danger">*</span></label>
        <input type="text" name="city" id="city" class="form-control" placeholder="Contoh: Jakarta Selatan" >
    </div>
    <div class="form-confirm">
        <label for="province" class="form-label">Provinsi<span class="text-danger">*</span></label>
        <input type="text" name="province" id="province" class="form-control" placeholder="Contoh: DKI Jakarta" >
    </div>
    <div class="form-confirm">
        <label for="postal_code" class="form-label">Kode Pos<span class="text-danger">*</span></label>
        <input type="text" name="postal_code" id="postal_code" class="form-control" pattern="[0-9]{5}" title="Masukkan 5 digit angka" placeholder="Contoh: 12520" >
    </div>
    <div class="form-confirm">
    <label for="courier" class="form-label">Kurir<span class="text-danger">*</span></label>
    <select name="courier" id="courier" class="form-control" >
        <option value="">-- Pilih Kurir --</option>
        <option value="jne">JNE</option>
        <option value="pos">POS</option>
        <option value="tiki">TIKI</option>
    </select>
</div>


<div class="form-confirm">
    <label class="form-label">Ongkos Kirim</label>
    <input type="text" readonly class="form-control" id="shipping_cost_display" value="Rp0">
    <input type="hidden" name="shipping_cost" id="shipping_cost">
</div>

</div>     
                {{-- Button Konfirmasi --}}
                <div class="text-center">
                    <button type="button" class="btn btn-md btn-primary mt-3 w-100" onclick="validateAndShowModal()">
                        Lanjut Pembayaran
                    </button>
                </div>
                {{-- Button Batalkan Pesanan --}}
<div class="text-center">
    <button type="button" class="btn btn-md btn-danger mt-2 w-100" data-bs-toggle="modal" data-bs-target="#batalModal">
        Batalkan Pesanan
    </button>
</div>

                </form>
                
<!-- Modal Konfirmasi Simpan Produk -->
<div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
    
      <div class="modal-body text-center">
        <p>Apakah kamu yakin ingin konfirmasi pesanan ini, dan lanjut ke pembayaran?</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batalkan</button>
        <button type="submit" class="btn btn-simpan" id="confirmSubmitBtn">Lanjut</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Pembatalan Pesanan -->
<div class="modal fade" id="batalModal" tabindex="-1" aria-labelledby="batalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
   
      <div class="modal-body text-center">
        <p>Apakah kamu yakin ingin membatalkan pesanan ini?</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Kembali</button>
        <form action="{{ route('order.cancel', $order->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Ya, Batalkan Pesanan</button>
        </form>
      </div>
    </div>
  </div>
</div>

            </div>
        </div>
    </div>


</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function validateAndShowModal() {
    const form = document.getElementById('formKonfirmasi');
    const alertBox = document.getElementById('formAlert');
    const inputs = form.querySelectorAll('input[required], select[required]');
    let allValid = true;
    let firstInvalidInput = null;

    inputs.forEach(input => {
        const isHidden = input.offsetParent === null;

        if (!isHidden && !input.value.trim()) {
            allValid = false;
            input.classList.add('is-invalid');
            if (!firstInvalidInput) {
                firstInvalidInput = input;
            }
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!allValid) {
        alertBox.classList.remove('d-none');
        // Scroll ke input pertama yang invalid dan fokus
        firstInvalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstInvalidInput.focus();
        return;
    } else {
        alertBox.classList.add('d-none');
    }

    // Tampilkan modal konfirmasi
    const modal = new bootstrap.Modal(document.getElementById('konfirmasiModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    const shippingMethod = document.getElementById('shipping_method');
    const alamatContainer = document.getElementById('alamatContainer');
    const submitKonfirmasi = document.getElementById('submitKonfirmasi');
    const formKonfirmasi = document.getElementById('formKonfirmasi');
    const postalCode = document.getElementById('postal_code');
    const courierSelect = document.getElementById('courier');
   
    const shippingCostDisplay = document.getElementById('shipping_cost_display');
    const shippingCostInput = document.getElementById('shipping_cost');

    // Tampilkan alamat jika metode kirim dipilih
    
    shippingMethod.addEventListener('change', function () {
    if (this.value === 'kirim') {
        alamatContainer.style.display = 'block';
        // Tambahkan required ke semua input di alamatContainer
        document.querySelectorAll('#alamatContainer input, #alamatContainer select').forEach(el => {
            el.setAttribute('required', 'required');
        });
    } else {
        alamatContainer.style.display = 'none';
        // Hapus required di semua input jika metode ambil
        document.querySelectorAll('#alamatContainer input, #alamatContainer select').forEach(el => {
            el.removeAttribute('required');
        });
    }
});

    // Submit form dari modal
    confirmSubmitBtn.addEventListener('click', function () {
        formKonfirmasi.submit();
    });

    // Event fetch ongkir ketika kode pos blur dan kurir dipilih
    postalCode.addEventListener('blur', tryFetchOngkir);
    courierSelect.addEventListener('change', tryFetchOngkir);

    // Event listener service
    serviceSelect.addEventListener('change', function () {
        const cost = this.value;
        shippingCostDisplay.value = cost ? 'Rp' + Number(cost).toLocaleString() : 'Rp0';
        shippingCostInput.value = cost || 0;
    });

    function tryFetchOngkir() {
        // Pastikan data lengkap
        if (postalCode.value.length === 5 && courierSelect.value !== '') {
            fetchOngkir();
        } else {
            resetOngkir();
        }
    }

    function resetOngkir() {
        serviceSelect.innerHTML = '<option value="">-- Pilih Layanan --</option>';
        shippingCostDisplay.value = 'Rp0';
        shippingCostInput.value = 0;
    }

    function fetchOngkir() {
        const originCode = 501; 
        const destinationCode = 114; 
        const weightInGrams = 1000;
        const courierCode = courierSelect.value;

        fetch('/cek-ongkir', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                origin: originCode,
                destination: destinationCode,
                weight: weightInGrams,
                courier: courierCode,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.details) {
                let options = '<option value="">-- Pilih Layanan --</option>';
                data.details.forEach(service => {
                    const cost = service.cost[0].value;
                    options += `<option value="${cost}">${service.service} - Rp${cost.toLocaleString()}</option>`;
                });
                serviceSelect.innerHTML = options;
            } else {
                resetOngkir();
                alert('Data ongkir tidak ditemukan.');
            }
        })
        .catch(() => {
            resetOngkir();
            alert('Gagal mengambil data ongkir.');
        });
    }
});
</script>
@endsection
