@extends('layouts.pelanggan')

@section('title', 'Detail Produk')

@section('content')

{{-- Header & Breadcrumb --}}
<header>
    <h1> {{ $product->category->name ?? '-' }}</h1>
    <nav aria-label="breadcrumb" class="breadcrumb-products d-flex justify-content-center">
        <ol class="breadcrumb bg-transparent p-2">
            <li class="breadcrumb-item">
                <a href="{{ route('pelanggan.beranda') }}">
                    <i class="fas fa-home me-1"></i> Beranda
                </a>
            </li>
            <li class="breadcrumb-item active text-white" aria-current="page"> Produk</li>
        </ol>
    </nav>
</header>

{{-- Produk --}}
<div class="container mt-5 py-5">
    <div class="row shadow-sm bg-white rounded mb-0">
        {{-- Gambar Produk --}}
        <div class="col-md-6 ">
            <div class="img-product border p-3 text-center mx-auto mt-3 mb-3" style="min-height: 400px; width: 100%; max-width: 900px;">
                <img id="mainPreview" src="{{ asset('storage/' . ($product->mainImage->image_path ?? 'default.jpg')) }}" alt="{{ $product->name }}"  class="img-fluid product-preview" style="max-height: 350px; object-fit: contain;">
            </div>
            <div class="d-flex gap-3 justify-content-justify">
                @foreach ($product->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail thumb {{ $loop->first ? 'active-thumb' : '' }}" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;" onclick="changeImage(this)">
                @endforeach
            </div>
            <!--<div class="p-3 rounded" style="background-color: #E6F2FF;">
                <p class="mb-2 fw-semibold">Catatan :</p>
                <ul class="mb-0 ps-3">
                    <li>File yang sudah ready</li>
                    <li>Jika file desain ada di drive anda atau jika anda ingin kustom desain, silahkan cantumkan di kolom deskripsi tambahan</li>
                    <li>Info pembayaran dan pengiriman lanjut di whatsapp admin</li>
                </ul>
            </div> -->
        </div>

        {{-- Form Pemesanan --}}
        <div class="col-md-6">
            <div class="form-pemesanan" style="position: sticky; top: 80px; max-height: 85vh; overflow-y: auto;">
                <h4 class="sub-heading">{{ $product->name }}</h4>
                <p class="heading">
                    <span class="text-muted">Harga mulai dari</span>
                    <span class="fs-5 fw-bold harga">Rp{{ number_format($product->base_price, 0, ',', '.') }}</span>
                </p>
                <div id="formAlert" class="alert alert-danger d-none">
    Field belum diisi semua. Silakan periksa kembali.
</div>
                <form id="productForm" action="{{ route('pelanggan.products.preorder', $product->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    {{-- Bahan --}}
                    @if ($product->materials->isNotEmpty())
                        <div class="form-group">
                            <label for="material" class="form-label">Bahan<span class="text-danger">*</span></label>
                            <select name="material_id" id="material" class="form-control @error('material_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach ($product->materials as $material)
                                    <option value="{{ $material->id }}" data-price="{{ $material->pivot->additional_price }}" 
    {{ old('material_id', $previousInput['material_id'] ?? '') == $material->id ? 'selected' : '' }}>
    {{ $material->name }}
</option>

                                @endforeach
                            </select>
                            @error('material_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    {{-- Ukuran --}}
                    @if ($product->sizes->isNotEmpty())
                        <div class="form-group">
                            <label for="size" class="form-label">Ukuran<span class="text-danger">*</span></label>
                            <select name="size_id" id="size" class="form-control @error('size_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Ukuran --</option>
                                @foreach ($product->sizes as $size)
                                    <option value="{{ $size->id }}" data-price="{{ $size->pivot->additional_price }}"
    {{ old('size_id', $previousInput['size_id'] ?? '') == $size->id ? 'selected' : '' }}>
    {{ $size->name }} @if($size->dimension) ({{ $size->dimension }}) @endif
</option>

                                @endforeach
                            </select>
                            @error('size_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    {{-- Laminasi --}}
                    @if ($product->laminations->isNotEmpty())
                        <div class="form-group">
                            <label for="lamination" class="form-label">Laminasi<span class="text-danger">*</span></label>
                            <select name="lamination_id" id="lamination" class="form-control @error('lamination_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Laminasi --</option>
                                @foreach ($product->laminations as $lamination)
                                    <option value="{{ $lamination->id }}" data-price="{{ $lamination->pivot->additional_price }}"
    {{ old('lamination_id', $previousInput['lamination_id'] ?? '') == $lamination->id ? 'selected' : '' }}>
    {{ $lamination->name }}
</option>

                                @endforeach
                            </select>
                            @error('lamination_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    {{-- Tambahan Form Fields --}}
@if (!empty($formFields) && is_array($formFields))
    @foreach ($formFields as $field)
        @php
            // Field dari database yang diinput admin di backend -> wajib diisi user
            $isRequired = true;
        @endphp

        <div class="form-group">
            <label for="{{ $field['name'] }}" class="form-label">
                {{ $field['label'] }}
                <span class="text-danger">*</span>
            </label>

            @switch($field['type'])
                @case('text')
                @case('number')
                    <input type="{{ $field['type'] }}" 
    name="form_fields[{{ $field['name'] }}]" 
    id="{{ $field['name'] }}" 
    class="form-control" 
    value="{{ old('form_fields.' . $field['name'], $previousInput['form_fields'][$field['name']] ?? '') }}" 
    required>


                    @break

                @case('textarea')
                    <textarea name="form_fields[{{ $field['name'] }}]" 
    id="{{ $field['name'] }}" 
    class="form-control" 
    rows="4" 
    required>{{ old('form_fields.' . $field['name'], $previousInput['form_fields'][$field['name']] ?? '') }}</textarea>

                    @break

                @case('select')
                    <select name="form_fields[{{ $field['name'] }}]" id="{{ $field['name'] }}" class="form-control" required>
                        <option value="">-- Pilih {{ $field['label'] }} --</option>
                        @foreach ($field['options'] ?? [] as $option)
                            @if(is_array($option) && isset($option['label']))
                                <option value="{{ $option['label'] ?? '' }}" 
    data-price="{{ $option['price'] ?? 0 }}"
    {{ old('form_fields.' . $field['name'], $previousInput['form_fields'][$field['name']] ?? '') == ($option['label'] ?? '') ? 'selected' : '' }}>
    {{ $option['label'] ?? '' }}
</option>


                            @endif
                        @endforeach
                    </select>
                    @break

                @case('file')
                    <input type="file" name="form_fields[{{ $field['name'] }}]" id="{{ $field['name'] }}" class="form-control" required>
                    @break

                @default
                    <input type="text" name="form_fields[{{ $field['name'] }}]" id="{{ $field['name'] }}" class="form-control" required>
            @endswitch
        </div>
    @endforeach
@endif


                    {{-- Jumlah --}}
                    <div class="form-group">
                        <label for="quantity" class="form-label">Jumlah<span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" min="1"  value="{{ old('quantity', $previousInput['quantity'] ?? 1) }}" required>
                        @error('quantity')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Option Upload Desain --}}
                    <div class="form-group">
                        <label class="form-label">Pilih Cara Mengirim Desain<span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input @error('design_input_type') is-invalid @enderror" type="radio" name="design_input_type" id="uploadOption" value="upload" {{ old('design_input_type', $previousInput['design_input_type'] ?? 'upload') === 'upload' ? 'checked' : '' }} onchange="toggleDesignInput()">
                            <label class="form-check-label" for="uploadOption">Upload File Desain</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('design_input_type') is-invalid @enderror" type="radio" name="design_input_type" id="linkOption" value="link" {{ old('design_input_type', $previousInput['design_input_type'] ?? '') === 'link' ? 'checked' : '' }} onchange="toggleDesignInput()">
                            <label class="form-check-label" for="linkOption">Link Google Drive / Desain Online</label>
                        </div>
                        @error('design_input_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Upload file --}}
                    <div class="form-group" id="uploadInput">
                        <label for="design_file" class="form-label">Upload File Desain</label>
                        <input type="file" name="design_file" id="design_file" class="form-control @error('design_file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @error('design_file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Link desain --}}
                    <div class="form-group d-none" id="linkInput">
                        <label for="design_link" class="form-label">Link Desain (Google Drive/dll)</label>
                        <input type="url" name="design_link" id="design_link" class="form-control @error('design_link') is-invalid @enderror" placeholder="https://drive.google.com/..." pattern="https?://.+" value="{{ old('design_link', $previousInput['design_link'] ?? '') }}">
                        @error('design_link')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Deskripsi Tambahan --}}
                    <div class="form-group mb-4">
                        <label for="custom_description" class="form-label">Deskripsi Tambahan</label>
                        <textarea name="custom_description" id="custom_description" class="form-control" rows="4" placeholder="Isi jika anda ingin custom">{{ old('custom_description', $previousInput['custom_description'] ?? '') }}</textarea>
                    </div>
                    {{-- Cek Harga --}}
                    <div class="price-check mt-3">
                        <p>Total Harga: <span id="totalHarga">Rp 0</span></p>
                        <button type="button" class="btn btn-secondary" onclick="hitungHarga()">Cek Harga</button>
                    </div>
                    {{-- Button Pesan Sekarang --}}
                    <div class="text-center">
                        
                        <button type="button" class="btn btn-md btn-primary mt-3 w-100" onclick="handleBeforeSubmit()">Pesan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{-- Deskripsi Produk --}}
    <div class="mt-5">
        <h4 class="sub-heading">Deskripsi Produk</h4>
        <p class="desc">{!! nl2br(e($product->description)) !!}</p>
    </div>
</div>

<!-- Testimoni Pelanggan -->
<!-- Testimoni Pelanggan -->
<div class="container py-5">
    <h4 class="sub-heading text-center mb-4">Apa Kata Pelanggan</h4>

    <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(4px);">
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row g-4">
                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">  
                                        <div>
                                            <h6 style="color: #FFA600">Andi Setiawan</h6>
                                        </div>
                                    </div>
                                    <p style="color: #60697B">“Hasil cetaknya bagus banget, sesuai harapan. Prosesnya cepat dan rapi!”</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-none d-md-block">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        
                                        <div>
                                            <h6 style="color: #FFA600">Siti Rahma</h6>
                                            
                                        </div>
                                    </div>
                                    <p style="color: #60697B">“Pelayanan sangat ramah dan hasil cetaknya mantap. Terima kasih Dulur Setting!”</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-none d-md-block">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        
                                        <div>
                                            <h6 style="color: #FFA600">Budi Hartono</h6>
                                            
                                        </div>
                                    </div>
                                    <p style="color: #60697B">“Kualitas cetakannya sangat memuaskan, dan harga bersahabat. Recomended!”</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 (untuk mobile slide berikutnya, desktop tetap 3 per slide) -->
                <div class="carousel-item">
                    <div class="row g-4">
                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        
                                        <div>
                                            <h6 style="color: #FFA600">Marlina</h6>
                                            
                                        </div>
                                    </div>
                                    <p style="color: #60697B">“Fast response dan hasil desain sangat memuaskan. Pasti repeat order!”</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-none d-md-block">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        
                                        <div>
                                            <h6 style="color: #FFA600">Riko Prasetyo</h6>
                                           
                                        </div>
                                    </div>
                                    <p style="color: #60697B">“Desainnya kreatif, hasil cetaknya presisi, puas banget dengan layanannya!”</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-none d-md-block">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        
                                        <div>
                                            <h6 style="color: #FFA600">Sarah Putri</h6>
                                            
                                        </div>
                                    </div>
                                    <p style="color: #60697B">“Senang banget bisa custom desain di sini. Prosesnya jelas dan cepat.”</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Navigasi Panah di Bawah -->
            <div class="d-flex justify-content-center mt-4 gap-3">
                <button class="btn btn-tertiary rounded-circle" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-tertiary rounded-circle" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>



{{-- Layanan Desain --}}
<section class="container layanan-desain">
    <div class="container-content" data-animate>
        <h4 class="sub-heading">Butuh bantuan mendesain?</h4>
        <p>Ingin desain sesuai keinginanmu? Bisa! Dulur Setting menyediakan layanan jasa desain grafis, termasuk desain kustom. Konsultasikan kebutuhanmu, dan kami siap bantu mewujudkannya lewat WhatsApp.</p>
        <a href="https://wa.me/62895612811600" class="btn btn-secondary btn-md">
            <i class="bi bi-whatsapp"></i> Konsultasikan via WhatsApp
        </a>
    </div>
</section>

{{-- Produk Terkait --}}
@if($relatedProducts->count())
    <section class="py-5 bg-light">
        <div class="container">
            <h4 class="heading-produk">Produk Terkait</h4>
            <div class="horizontal-scroll d-flex gap-4 overflow-auto pb-2">
                @foreach ($relatedProducts as $related)
                    <div class="flex-shrink-0" style="width: 230px;">
                        <a href="{{ route('pelanggan.products.show', $related->id) }}" class="text-decoration-none text-dark">
                            <div class="product-card" style="shadow-sm; padding: 16px; border-radius: 8px;">
                                <img src="{{ asset('storage/' . ($related->mainImage->image_path ?? 'default.jpg')) }}" style="width: 100%; height: 180px; object-fit: cover; border-radius: 5px;" onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';" alt="{{ $related->name }}">
                                <p class="product-title">{{ $related->name }}</p>
                                <div class="price">Harga dari Rp{{ number_format($related->base_price, 0, ',', '.') }}</div>
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
  <script>
    function hitungHarga() {
        const basePrice = {{ $product->base_price ?? 0 }};
        const materialSelect = document.getElementById('material');
        const sizeSelect = document.getElementById('size');
        const laminationSelect = document.getElementById('lamination');
        const quantityInput = document.getElementById('quantity');

        // Ambil harga tambahan 
        const materialPrice = materialSelect ? parseFloat(materialSelect?.selectedOptions[0]?.dataset.price || 0) : 0;
        const sizePrice = sizeSelect ? parseFloat(sizeSelect?.selectedOptions[0]?.dataset.price || 0) : 0;
        const laminationPrice = laminationSelect ? parseFloat(laminationSelect?.selectedOptions[0]?.dataset.price || 0) : 0;
        const quantity = parseInt(quantityInput.value || 1);

        if ((materialSelect && !materialSelect.value) || (sizeSelect && !sizeSelect.value) || isNaN(quantity) || quantity < 1) {
            alert("Mohon lengkapi bahan, ukuran, dan jumlah sebelum menghitung harga.");
            return;
        }

        let extraPrice = 0;
        document.querySelectorAll('select[name^="form_fields["]').forEach(select => {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.dataset.price) {
                const hargaTambahan = parseFloat(selectedOption.dataset.price);
                if (!isNaN(hargaTambahan)) {
                    extraPrice += hargaTambahan;
                }
            }
        });

        const total = (basePrice + materialPrice + sizePrice + laminationPrice + extraPrice) * quantity;
        document.getElementById('totalHarga').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    function changeImage(element) {
        const mainImage = document.getElementById('mainPreview');
        if (mainImage && element?.src) {
            mainImage.src = element.src;
        }
        document.querySelectorAll('.thumb').forEach(img => img.classList.remove('active-thumb'));
        element.classList.add('active-thumb');
    }

    function toggleDesignInput() {
        const uploadDiv = document.getElementById('uploadInput');
        const linkDiv = document.getElementById('linkInput');
        const isUpload = document.getElementById('uploadOption').checked;

        uploadDiv.classList.toggle('d-none', !isUpload);
        linkDiv.classList.toggle('d-none', isUpload);
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleDesignInput();
    });

    function handleBeforeSubmit() {
    const form = document.getElementById('productForm');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    let firstInvalid = null;

    // Cek input biasa
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            if (!firstInvalid) firstInvalid = field;
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Cek desain
    const designType = form.querySelector('input[name="design_input_type"]:checked');
    const uploadInput = document.getElementById('design_file');
    const linkInput = document.getElementById('design_link');

    if (!designType) {
        isValid = false;
        if (!firstInvalid) firstInvalid = form.querySelector('input[name="design_input_type"]');
    } else {
        if (designType.value === 'upload' && !uploadInput.files.length) {
            uploadInput.classList.add('is-invalid');
            isValid = false;
            if (!firstInvalid) firstInvalid = uploadInput;
        } else {
            uploadInput.classList.remove('is-invalid');
        }

        if (designType.value === 'link' && !linkInput.value.trim()) {
            linkInput.classList.add('is-invalid');
            isValid = false;
            if (!firstInvalid) firstInvalid = linkInput;
        } else {
            linkInput.classList.remove('is-invalid');
        }
    }

    const alertBox = document.getElementById('formAlert');
    if (!isValid) {
        if (alertBox) alertBox.classList.remove('d-none');
        if (firstInvalid) {
            firstInvalid.focus();
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
    }

    if (alertBox) alertBox.classList.add('d-none');

    // ✅ Submit form jika valid
    form.submit();
}

</script>
@endsection
