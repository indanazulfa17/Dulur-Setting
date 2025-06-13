@extends('layouts.pelanggan')

@section('title', 'Detail Produk')

@section('content')
<header>
    <h1> {{ $product->category->name ?? '-' }}</h1>
  </header>
<div class="container mt-5">
    

    {{-- Detail Produk --}}
    <div class="row gx-5 mb-5">

    <!-- Gambar dan Thumbnail -->
<div class="col-md-6">
    {{-- Card Gambar Utama --}}
    <div class="border rounded p-3 text-center mx-auto mb-3" style="min-height: 320px; width: 100%; max-width: 900px;">

        <img 
            id="mainPreview"
            src="{{ asset('storage/' . ($product->mainImage->image_path ?? 'default.jpg')) }}" 
            alt="{{ $product->name }}" 
            style="max-height: 280px; object-fit: contain;"
            class="img-fluid"
        >
    </div>

    {{-- Thumbnail --}}
    <div class="d-flex gap-3 justify-content-justify">
        @foreach ($product->images as $image)
            <img 
                src="{{ asset('storage/' . $image->image_path) }}" 
                class="img-thumbnail thumb {{ $loop->first ? 'active-thumb' : '' }}"
                style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                onclick="changeImage(this)"
            >
        @endforeach
    </div>
</div>


    <!-- Informasi Produk -->
    <div class="col-md-6">
        <h4 class="mb-4">{{ $product->name }}</h4>
         <p class="mb-3">
            <span class="text-muted">Harga dari</span>
        <span class="fs-5 fw-bold text-warning">Rp{{ number_format($product->base_price, 0, ',', '.') }}</span>
        
    </p>

    <p><strong> Durasi Pengerjaan</strong><br>{!! nl2br(e($product->description)) !!}</br></p>
    <div class="p-3 rounded" style="background-color: #E6F2FF;">
        <p class="mb-2 fw-semibold">Catatan :</p>
        <ul class="mb-0 ps-3">
            <li>File yang sudah ready</li>
            <li>Jika file desain ada di drive anda atau jika anda ingin kustom desain, silahkan cantumkan di kolom deskripsi tambahan</li>
            <li>Info pembayaran dan pengiriman lanjut di whatsapp admin</li>
        </ul>
    </div>
    </div>
</div>


    {{-- Error --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Form Pemesanan --}}
    <div class="form-pemesanan">
        <h4 class="heading-form">Form Pemesanan</h4>
        <form action="{{ route('pelanggan.products.preorder', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            @if (!empty($formFields) && is_array($formFields))
                @foreach ($formFields as $field)
                    <div class="mb-3">
                        <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>

                        @switch($field['type'])
                            @case('text')
                            @case('number')
                                <input 
                                    type="{{ $field['type'] }}" 
                                    name="{{ $field['name'] }}" 
                                    id="{{ $field['name'] }}" 
                                    class="form-control"
                                    @if(!empty($field['required'])) required @endif
                                >
                                @break

                            @case('textarea')
                                <textarea 
                                    name="{{ $field['name'] }}" 
                                    id="{{ $field['name'] }}" 
                                    class="form-control" 
                                    rows="4"
                                    @if(!empty($field['required'])) required @endif
                                ></textarea>
                                @break

                            @case('select')
                                <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control" @if(!empty($field['required'])) required @endif>
                                    <option value="">-- Pilih {{ $field['label'] }} --</option>
                                    @foreach ($field['options'] as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @break

                            @case('file')
                                <input 
                                    type="file" 
                                    name="{{ $field['name'] }}" 
                                    id="{{ $field['name'] }}" 
                                    class="form-control"
                                    @if(!empty($field['required'])) required @endif
                                >
                                @break

                            @default
                                <input 
                                    type="text" 
                                    name="{{ $field['name'] }}" 
                                    id="{{ $field['name'] }}" 
                                    class="form-control"
                                    @if(!empty($field['required'])) required @endif
                                >
                        @endswitch
                    </div>
                @endforeach
            @else
            {{-- Form default jika tidak ada form_fields --}}
                <div class="form-grid">
                    <div class="form-group">
                        <label for="material" class="form-label">Pilih Bahan</label>
                        <select name="material_id" id="material" class="form-control" required>
                            <option value="">-- Pilih Bahan --</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" data-price="{{ $material->additional_price }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="size" class="form-label">Pilih Ukuran</label>
                        <select name="size_id" id="size" class="form-control" required>
                            <option value="">-- Pilih Ukuran --</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" data-price="{{ $size->additional_price }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="lamination" class="form-label">Pilih Laminasi (Opsional)</label>
                        <select name="lamination_id" id="lamination" class="form-control">
                            <option value="">-- Tanpa Laminasi --</option>
                            @foreach ($laminations as $lamination)
                                <option value="{{ $lamination->id }}" data-price="{{ $lamination->additional_price }}">{{ $lamination->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity" class="form-label">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="file" class="form-label">Upload File Desain</label>
                        <input type="file" name="design_file" id="design_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">

                    </div>

                    <div class="form-group">
                        <label for="custom_description" class="form-label">Deskripsi Tambahan</label>
                        <textarea name="custom_description" id="custom_description" class="form-control" rows="4"></textarea>
                    </div>
                </div>

                {{-- Cek Harga --}}
                <div class="price-check mt-3">
                    <p>Total Harga: <span id="totalHarga">Rp 0</span></p>
                    <button type="button" class="btn btn-secondary" onclick="hitungHarga()">Cek Harga</button>
                </div>
            @endif
            <div class="text-center">
                    <button type="submit" class="btn btn-md btn-primary mt-3 w-100">Pesan Sekarang</button>
                </div>
        </form>
    </div>
    </div>
    {{-- Produk Terkait --}}
@if($relatedProducts->count())
<section class="py-5 bg-light">
    <div class="container">
    <h4 class="heading-produk">Produk Terkait</h4>
    <div class="horizontal-scroll d-flex gap-4 overflow-auto pb-2">
        @foreach ($relatedProducts as $related)
            <div class="flex-shrink-0" style="width: 230px;">
                <a href="{{ route('pelanggan.products.show', $related->id) }}" class="text-decoration-none text-dark">
                    <div class="product-card" style="border: 1px solid #ddd; padding: 16px; border-radius: 5px;">
                        <img 
                            src="{{ asset('storage/' . ($related->mainImage->image_path ?? 'default.jpg')) }}" 
                            style="width: 100%; height: 180px; object-fit: cover; border-radius: 5px;" 
                            onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';"
                            alt="{{ $related->name }}">
                        <p class="product-title">{{ $related->name }}</p>
                        <div class="price">
                            Harga dari Rp{{ number_format($related->base_price, 0, ',', '.') }}
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    </div>
</section>
@endif


@endsection


@section('scripts')
@if (empty($formFields))
<script>
    function hitungHarga() {
        let basePrice = {{ $product->base_price ?? 0 }};
        let materialSelect = document.querySelector('#material');
        let sizeSelect = document.querySelector('#size');
        let laminationSelect = document.querySelector('#lamination');
        let quantityInput = document.querySelector('#quantity');

        let materialPrice = parseFloat(materialSelect.options[materialSelect.selectedIndex]?.dataset.price || 0);
        let sizePrice = parseFloat(sizeSelect.options[sizeSelect.selectedIndex]?.dataset.price || 0);
        let laminationPrice = parseFloat(laminationSelect.options[laminationSelect.selectedIndex]?.dataset.price || 0);
        let quantity = parseInt(quantityInput.value || 0);

        if (isNaN(quantity) || quantity < 1) {
            alert("Jumlah harus lebih dari 0");
            return;
        }

        let total = (basePrice + materialPrice + sizePrice + laminationPrice) * quantity;
        document.getElementById('totalHarga').innerText = 'Rp' + total.toLocaleString('id-ID');
    }
</script>
<script>
    function changeImage(element) {
    document.getElementById('mainPreview').src = element.src;

    // Hapus highlight dari semua thumbnail
    document.querySelectorAll('.thumb').forEach(img => {
        img.classList.remove('active-thumb');
    });

    // Tambahkan highlight ke thumbnail aktif
    element.classList.add('active-thumb');
}

</script>

@endif
<!-- Tombol WhatsApp Sticky dengan Font Awesome -->
<a href="https://wa.me/62895612811600" class="whatsapp-float" target="_blank" title="Hubungi kami via WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
@endsection
