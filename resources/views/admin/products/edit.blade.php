@extends('layouts.admin')

@section('content')
<div class="container mt-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.index') }}"> Produk </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"> Edit Produk </li>
        </ol>
    </nav>

    <div class="container-produk">
        <h4 class="heading">Edit Produk</h4>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="productForm" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Informasi Produk --}}
            <div class="card mb-4">
                <div class="card-head">Informasi Produk</div>
                <div class="card-body">
                    <div class="form">
                        <label class="form-label">Nama Produk<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="form">
                        <label class="form-label">Deskripsi<span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Gambar --}}
                    <div class="form">
                        <label class="form-label">Gambar Produk</label><br>
                        @if ($product->images->count() > 0)
                            <div class="mb-3 d-flex flex-wrap gap-2">
                                @foreach($product->images as $image)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" style="width: 120px;">
                                        <label class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="cursor: pointer;">
                                            ✖ <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" hidden>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Belum ada gambar.</p>
                        @endif
                        <input type="file" name="images[]" class="form-control mt-2" multiple accept="image/*">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form">
                                <label class="form-label">Kategori<span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form">
                                <label class="form-label">Harga Dasar (Rp)<span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" value="{{ old('price', $product->base_price) }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bahan --}}
            <div class="card mb-4">
                <div class="card-head">Bahan</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle rounded table-borderless" id="materialTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nama Bahan <span class="text-danger">*</span></th>
                                    <th>Harga Tambahan (Rp)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($product->materials as $index => $material)
                                    <tr>
                                        <td>
                                            <input type="text" name="materials[{{ $index }}][name]" value="{{ $material->name }}" class="form-control" readonly>
                                            <input type="hidden" name="materials[{{ $index }}][id]" value="{{ $material->id }}">
                                        </td>
                                        <td>
                                            <input type="number" name="materials[{{ $index }}][additional_price]" value="{{ $material->pivot->additional_price }}" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada bahan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button type="button" onclick="addMaterialRow()" class="btn btn-tertiary btn-sm">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Bahan
                    </button>
                </div>
            </div>

            {{-- Ukuran --}}
            <div class="card mb-4">
                <div class="card-head">Ukuran Produk</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle rounded table-borderless" id="sizeTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nama Ukuran <span class="text-danger">*</span></th>
                                    <th>Dimensi</th>
                                    <th>Harga Tambahan (Rp)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($product->sizes as $index => $size)
                                    <tr>
                                        <td><input type="text" name="sizes[{{ $index }}][name]" value="{{ $size->name }}" class="form-control" readonly></td>
                                        <td><input type="text" name="sizes[{{ $index }}][dimension]" value="{{ $size->dimension }}" class="form-control" readonly></td>
                                        <td><input type="number" name="sizes[{{ $index }}][additional_price]" value="{{ $size->pivot->additional_price }}" class="form-control"></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada ukuran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button type="button" onclick="addSizeRow()" class="btn btn-tertiary btn-sm">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Ukuran
                    </button>
                </div>
            </div>

            {{-- Laminasi --}}
            <div class="card mb-4">
                <div class="card-head">Laminasi</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle rounded table-borderless" id="laminationTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Jenis Laminasi <span class="text-danger">*</span></th>
                                    <th>Harga Tambahan (Rp)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($product->laminations as $index => $lamination)
                                    <tr>
                                        <td>
                                            <input type="text" name="laminations[{{ $index }}][name]" value="{{ $lamination->name }}" class="form-control" readonly>
                                            <input type="hidden" name="laminations[{{ $index }}][id]" value="{{ $lamination->id }}">
                                        </td>
                                        <td><input type="number" name="laminations[{{ $index }}][additional_price]" value="{{ $lamination->pivot->additional_price }}" class="form-control"></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada laminasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button type="button" onclick="addLaminationRow()" class="btn btn-tertiary btn-sm">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Laminasi
                    </button>
                </div>
            </div>

            {{-- Field Tambahan --}}
<div class="card mb-4">
    <div class="card-head">Field Tambahan (Opsional)</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle rounded table-borderless" id="customFieldTable">
                <thead class="bg-light">
                    <tr>
                        <th><label class="table-label">Label</label></th>
                        <th><label class="table-label">Nama Input</label></th>
                        <th><label class="table-label">Opsi dan Harga</label></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="fieldTableBody">
                    {{-- Field lama --}}
                    @php
                        $fields = $product->form_fields ? json_decode($product->form_fields, true) : [];
                    @endphp

                    @if(count($fields) > 0)
                        @foreach($fields as $index => $field)
                            <tr>
                                <td class="align-top py-2" style="min-width: 180px;">
                                    <input type="text" class="form-control" data-key="label" value="{{ $field['label'] }}" placeholder="Contoh: Warna">
                                </td>
                                <td class="align-top py-2" style="min-width: 140px;">
                                    <input type="text" class="form-control" data-key="name" value="{{ $field['name'] }}" placeholder="Warna">
                                </td>
                                <td class="align-top py-2">
                                    <div class="option-wrapper">
                                        @foreach($field['options'] as $opt)
                                            <div class="d-flex mb-2 option-row">
                                                <input type="text" class="form-control me-2 option-label" value="{{ $opt['label'] }}" placeholder="Contoh: Merah">
                                                <input type="number" class="form-control me-2 option-price" value="{{ $opt['price'] }}" placeholder="Harga">
                                                <button type="button" class="btn btn-tertiary-2 btn-sm" title="Hapus opsi ini" onclick="removeOption(this)">
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="addOption(this)" class="btn btn-tertiary-2 btn-sm mt-2">
                                        <i class="fa-solid fa-circle-plus"></i> Opsi
                                    </button>
                                </td>
                                <td class="align-top text-center py-2">
                                    <button type="button" class="btn btn-tertiary-danger btn-sm" title="Hapus field ini" onclick="removeRow(this)">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada field tambahan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <button type="button" onclick="addFormFieldRow()" class="btn btn-tertiary btn-sm">
            <i class="fa-solid fa-circle-plus"></i> Tambah Field
        </button>
        <input type="hidden" name="form_fields_json" id="form_fields_json">
    </div>
</div>


            {{-- Tombol Simpan --}}
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary btn-md">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
/**
 * Hapus baris tabel
 */
function removeRow(button) {
    button.closest('tr').remove();
}

/**
 * Tambah baris Material
 */
function addMaterialRow() {
    const table = document.querySelector("#materialTable tbody");
    const index = table.rows.length;
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" name="materials[${index}][name]" class="form-control" placeholder="Nama Bahan"></td>
        <td><input type="number" name="materials[${index}][additional_price]" class="form-control" placeholder="Harga Tambahan"></td>
        <td class="text-center">
            <button type="button" class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </td>
    `;
    table.appendChild(row);
}

/**
 * Tambah baris Ukuran
 */
function addSizeRow() {
    const table = document.querySelector("#sizeTable tbody");
    const index = table.rows.length;
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" name="sizes[${index}][name]" class="form-control" placeholder="Nama Ukuran"></td>
        <td><input type="text" name="sizes[${index}][dimension]" class="form-control" placeholder="Dimensi"></td>
        <td><input type="number" name="sizes[${index}][additional_price]" class="form-control" placeholder="Harga Tambahan"></td>
        <td class="text-center">
            <button type="button" class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </td>
    `;
    table.appendChild(row);
}

/**
 * Tambah baris Laminasi
 */
function addLaminationRow() {
    const table = document.querySelector("#laminationTable tbody");
    const index = table.rows.length;
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" name="laminations[${index}][name]" class="form-control" placeholder="Jenis Laminasi"></td>
        <td><input type="number" name="laminations[${index}][additional_price]" class="form-control" placeholder="Harga Tambahan"></td>
        <td class="text-center">
            <button type="button" class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </td>
    `;
    table.appendChild(row);
}

/**
 * Tambah baris Field Tambahan
 */
function addFormFieldRow() {
    const tbody = document.getElementById('fieldTableBody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td class="align-top py-2" style="min-width: 180px;">
            <input type="text" class="form-control" data-key="label" placeholder="Contoh: Warna">
        </td>
        <td class="align-top py-2" style="min-width: 140px;">
            <input type="text" class="form-control" data-key="name" placeholder="Warna">
        </td>
        <td class="align-top py-2">
            <div class="option-wrapper">
                <div class="d-flex mb-2 option-row">
                    <input type="text" class="form-control me-2 option-label" placeholder="Contoh: Merah">
                    <input type="number" class="form-control me-2 option-price" placeholder="Harga" value="0">
                    <button type="button" class="btn btn-tertiary-2 btn-sm" title="Hapus opsi ini" onclick="removeOption(this)">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                </div>
            </div>
            <button type="button" onclick="addOption(this)" class="btn btn-tertiary-2 btn-sm " >
                <i class="fa-solid fa-circle-plus"></i></i>Opsi
            </button> 
        </td>
        <td class="align-top text-center py-2">
            <button class="btn btn-tertiary-danger btn-sm" title="Hapus field ini" onclick="removeRow(this)">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </td>
    `;
    tbody.appendChild(row);
}

/**
 * Tambah Opsi di Field Tambahan
 */
function addOption(button) {
    const wrapper = button.parentElement.querySelector('.option-wrapper');
    const optionRow = document.createElement('div');
    optionRow.classList.add('d-flex', 'mb-2', 'option-row');

    optionRow.innerHTML = `
        <div class="d-flex mb-2 option-row">
                    <input type="text" class="form-control me-2 option-label" placeholder="Nama Opsi">
                    <input type="number" class="form-control me-2 option-price" placeholder="Harga" value="0">
                    <button type="button" class="btn btn-tertiary-2 btn-sm" title="Hapus opsi ini" onclick="removeOption(this)">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                </div> 
    `;
    wrapper.appendChild(optionRow);
}

/**
 * Hapus Opsi Field Tambahan
 */
function removeOption(button) {
    button.closest('.option-row').remove();
}

/**
 * Sebelum submit, ubah field tambahan ke JSON
 */
document.getElementById('productForm').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('#fieldTableBody tr');
    const result = [];

    rows.forEach(row => {
        const label = row.querySelector('[data-key="label"]').value.trim();
        const name = row.querySelector('[data-key="name"]').value.trim();

        const options = [];
        row.querySelectorAll('.option-row').forEach(opt => {
            const optLabel = opt.querySelector('.option-label').value.trim();
            const optPrice = parseFloat(opt.querySelector('.option-price').value) || 0;

            if (optLabel) {
                options.push({ label: optLabel, price: optPrice });
            }
        });

        if (label && name && options.length > 0) {
            result.push({ label: label, name: name, type: "select", options: options });
        }
    });

    document.getElementById('form_fields_json').value = JSON.stringify(result);
});
</script>
@endpush
