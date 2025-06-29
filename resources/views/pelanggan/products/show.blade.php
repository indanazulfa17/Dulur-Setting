@extends('layouts.pelanggan')

@section('title', 'Detail Produk')

@section('content')
<header>
    <h1> {{ $product->category->name ?? '-' }}</h1>
    <nav aria-label="breadcrumb" class="breadcrumb-products d-flex justify-content-center mb-2">
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

<div class="container mt-5">
    <div class="row gx-5 mb-5">
        <div class="col-md-6">
            <div class="form-pemesanan p-3 text-center mx-auto mb-3" style="min-height: 400px; width: 100%; max-width: 900px;">
                <img id="mainPreview" src="{{ asset('storage/' . ($product->mainImage->image_path ?? 'default.jpg')) }}" alt="{{ $product->name }}"  class="img-fluid product-preview"
     style="max-height: 280px; object-fit: contain;">
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

        <div class="col-md-6">
            <div class="form-pemesanan" style="position: sticky; top: 80px; max-height: 85vh; overflow-y: auto;">
                <h4 class="mb-4">{{ $product->name }}</h4>
                <p class="mb-3">
                    <span class="text-muted">Harga dari</span>
                    <span class="fs-5 fw-bold harga">Rp{{ number_format($product->base_price, 0, ',', '.') }}</span>
                </p>
        
                <form action="{{ route('pelanggan.products.preorder', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">


                    {{-- Material --}}
                    @if ($product->materials->isNotEmpty())
                        <div class="form-group">
                            <label for="material" class="form-label">Bahan<span class="text-danger">*</span></label>
                            <select name="material_id" id="material" class="form-control" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach ($product->materials as $material)
                                    <option value="{{ $material->id }}" data-price="{{ $material->pivot->additional_price }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Size --}}
                    @if ($product->sizes->isNotEmpty())
                        <div class="form-group">
                            <label for="size" class="form-label">Ukuran<span class="text-danger">*</span></label>
                            <select name="size_id" id="size" class="form-control" required>
                                <option value="">-- Pilih Ukuran --</option>
                                @foreach ($product->sizes as $size)
                                    <option value="{{ $size->id }}" data-price="{{ $size->pivot->additional_price }}">{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Lamination --}}
                    @if ($product->laminations->isNotEmpty())
                        <div class="form-group">
                            <label for="lamination" class="form-label">Laminasi<span class="text-danger">*</span></label>
                            <select name="lamination_id" id="lamination" class="form-control" required>
                                <option value="">-- Pilih Laminasi --</option>
                                @foreach ($product->laminations as $lamination)
                                    <option value="{{ $lamination->id }}" data-price="{{ $lamination->pivot->additional_price }}">{{ $lamination->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Dynamic Form Fields --}}
                    @if (!empty($formFields) && is_array($formFields))
                        @foreach ($formFields as $field)
                            <div class="form-group">
                                <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>
                                @switch($field['type'])
                                    @case('text')
                                    @case('number')
                                        <input type="{{ $field['type'] }}" name="form_fields[{{ $field['name'] }}]" id="{{ $field['name'] }}" class="form-control" @if(!empty($field['required'])) required @endif>
                                        @break

                                    @case('textarea')
                                        <textarea name="form_fields[{{ $field['name'] }}]" id="{{ $field['name'] }}" class="form-control" rows="4" @if(!empty($field['required'])) required @endif></textarea>
                                        @break

                                    @case('select')
                                        <select name="form_fields[{{ $field['name'] }}]" id="{{ $field['name'] }}" class="form-control" @if(!empty($field['required'])) required @endif>
                                            <option value="">-- Pilih {{ $field['label'] }} --</option>
                                            @foreach ($field['options'] ?? [] as $option)
                                                @if(is_array($option) && isset($option['label']))
                                                    <option value="{{ $option['label'] }}" data-price="{{ $option['price'] ?? 0 }}">
                                                        {{ $option['label'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @break

                                    @case('file')
                                        <input type="file" name="form_fields[{{ $field['name'] }}]" id="{{ $field['name'] }}" class="form-control" @if(!empty($field['required'])) required @endif>
                                        @break

                                    @default
                                        <input type="text" name="form_fields[{{ $field['name'] }}]" id="{{ $field['name'] }}" class="form-control" @if(!empty($field['required'])) required @endif>
                                @endswitch
                            </div>
                        @endforeach
                    @endif

                    {{-- Jumlah --}}
                    <div class="form-group">
                        <label for="quantity" class="form-label">Jumlah<span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>

                    {{-- Option Upload Desain --}}
                    <div class="form-group">
                        <label class="form-label">Pilih Cara Mengirim Desain<span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="design_input_type" id="uploadOption" value="upload" checked onchange="toggleDesignInput()">
                            <label class="form-check-label" for="uploadOption">Upload File Desain</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="design_input_type" id="linkOption" value="link" onchange="toggleDesignInput()">
                            <label class="form-check-label" for="linkOption">Link Google Drive / Desain Online</label>
                        </div>
                    </div>
                    <div class="form-group" id="uploadInput">
                        <label for="design_file" class="form-label">Upload File Desain</label>
                        <input type="file" name="design_file" id="design_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    <div class="form-group d-none" id="linkInput">
                        <label for="design_link" class="form-label">Link Desain (Google Drive/dll)</label>
                        <input type="url" name="design_link" id="design_link" class="form-control" placeholder="https://drive.google.com/..." pattern="https?://.+">
                    </div>

                    {{-- Deskripsi Tambahan --}}
                    <div class="form-group mb-4">
                        <label for="custom_description" class="form-label">Deskripsi Tambahan</label>
                        <textarea name="custom_description" id="custom_description" class="form-control" rows="4" placeholder="Isi jika ada permintaan khusus"></textarea>
                    </div>

                    {{-- Cek Harga --}}
                    <div class="price-check mt-3">
                        <p>Total Harga: <span id="totalHarga">Rp 0</span></p>
                        <button type="button" class="btn btn-secondary" onclick="hitungHarga()">Cek Harga</button>
                    </div>

                    {{-- Button Pesan Sekarang --}}
                    <div class="text-center">
                        <button type="submit" class="btn btn-md btn-primary mt-3 w-100">Pesan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p><strong>Deskripsi Produk</strong><br>{!! nl2br(e($product->description)) !!}</p>

</div>

<!-- Layanan Desain -->
<section class="container layanan-desain">
    <div class="container-content" data-animate>
        <h4 class="mb-4">Butuh bantuan mendesain?</h4>
        <p>Ingin desain sesuai keinginanmu? Bisa! Dulur Setting menyediakan layanan jasa desain grafis, termasuk desain kustom. Konsultasikan kebutuhanmu, dan kami siap bantu mewujudkannya lewat WhatsApp.</p>
        <a href="https://wa.me/62895612811600" class="btn btn-secondary btn-md">
            <i class="bi bi-whatsapp"></i> Konsultasikan via WhatsApp
        </a>
    </div>
</section>

@if($relatedProducts->count())
    <section class="py-5 bg-light">
        <div class="container">
            <h4 class="heading-produk">Produk Terkait</h4>
            <div class="horizontal-scroll d-flex gap-4 overflow-auto pb-2">
                @foreach ($relatedProducts as $related)
                    <div class="flex-shrink-0" style="width: 230px;">
                        <a href="{{ route('pelanggan.products.show', $related->id) }}" class="text-decoration-none text-dark">
                            <div class="product-card" style="border: 1px solid #ddd; padding: 16px; border-radius: 5px;">
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

<a href="https://wa.me/62895612811600" class="whatsapp-float" target="_blank" title="Hubungi kami via WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
@endsection

@section('scripts')
<script>
    function hitungHarga() {
        const basePrice = {{ $product->base_price ?? 0 }};
        const materialSelect = document.getElementById('material');
        const sizeSelect = document.getElementById('size');
        const laminationSelect = document.getElementById('lamination');
        const quantityInput = document.getElementById('quantity');

        // Ambil harga tambahan jika ada
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
</script>
@endsection
