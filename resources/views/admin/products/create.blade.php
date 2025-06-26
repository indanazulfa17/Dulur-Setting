@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tambah Produk Baru</h2>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informasi Produk --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Informasi Produk
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Kartu Nama Elegan" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan fitur produk..." required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Dasar (Rp)</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="images[]" class="form-control" multiple required>
                </div>
            </div>
        </div>

        {{-- Material --}}
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                Bahan / Material
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="materialTable">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Material</th>
                            <th>Harga Tambahan (Rp)</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="new_materials[0][name]" class="form-control" placeholder="Contoh: Art Paper" required></td>
                            <td><input type="number" name="new_materials[0][additional_price]" class="form-control" value="0"></td>
                            <td class="text-center">
                                <button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" onclick="addMaterialRow()" class="btn btn-outline-primary btn-sm">
                    + Tambah Material
                </button>
            </div>
        </div>

        {{-- Ukuran --}}
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                Ukuran Produk
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="sizeTable">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Ukuran</th>
                            <th>Dimensi</th>
                            <th>Harga Tambahan (Rp)</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="new_sizes[0][name]" class="form-control" placeholder="Contoh: A5" required></td>
                            <td><input type="text" name="new_sizes[0][dimension]" class="form-control" placeholder="Contoh: 14.8 x 21 cm" required></td>
                            <td><input type="number" name="new_sizes[0][additional_price]" class="form-control" value="0"></td>
                            <td class="text-center">
                                <button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" onclick="addSizeRow()" class="btn btn-outline-success btn-sm">
                    + Tambah Ukuran
                </button>
            </div>
        </div>

        {{-- Laminasi --}}
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                Laminasi Produk
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="laminationTable">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Laminasi</th>
                            <th>Harga Tambahan (Rp)</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="new_laminations[0][name]" class="form-control" placeholder="Contoh: Glossy" required></td>
                            <td><input type="number" name="new_laminations[0][additional_price]" class="form-control" value="0"></td>
                            <td class="text-center">
                                <button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" onclick="addLaminationRow()" class="btn btn-outline-success btn-sm">
                    + Tambah Laminasi
                </button>
            </div>
        </div>

        {{-- Field Tambahan (Opsional) --}}
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                Field Tambahan (Opsional)
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="fieldTable">
                    <thead class="table-light">
                        <tr>
                            <th>Label</th>
                            <th>Nama Input</th>
                            <th>Opsi dan Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="fieldTableBody">
                        <!-- Baris akan ditambahkan dengan JavaScript -->
                    </tbody>
                </table>
                <button type="button" onclick="addFormFieldRow()" class="btn btn-outline-warning btn-sm">
                    + Tambah Field
                </button>
                <input type="hidden" name="form_fields_json" id="form_fields_json">
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success btn-lg">Simpan Produk</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let fieldIndex = 0;
let materialIndex = 1;
let sizeIndex = 1;
let laminationIndex = 1;


function addMaterialRow() {
    const table = document.getElementById('materialTable').querySelector('tbody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" name="new_materials[${materialIndex}][name]" class="form-control" required></td>
        <td><input type="number" name="new_materials[${materialIndex}][additional_price]" class="form-control" value="0"></td>
        <td class="text-center"><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">Hapus</button></td>
    `;
    table.appendChild(row);
    materialIndex++;
}

function addSizeRow() {
    const table = document.getElementById('sizeTable').querySelector('tbody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" name="new_sizes[${sizeIndex}][name]" class="form-control" required></td>
        <td><input type="text" name="new_sizes[${sizeIndex}][dimension]" class="form-control" required></td>
        <td><input type="number" name="new_sizes[${sizeIndex}][additional_price]" class="form-control" value="0"></td>
        <td class="text-center"><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">Hapus</button></td>
    `;
    table.appendChild(row);
    sizeIndex++;
}

function addLaminationRow() {
    const table = document.getElementById('laminationTable').querySelector('tbody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" name="new_laminations[${laminationIndex}][name]" class="form-control" required></td>
        <td><input type="number" name="new_laminations[${laminationIndex}][additional_price]" class="form-control" value="0"></td>
        <td class="text-center"><button type="button" onclick="removeRow(this)" class="btn btn-sm btn-danger">Hapus</button></td>
    `;
    table.appendChild(row);
    laminationIndex++;
}

function addFormFieldRow() {
    const tbody = document.getElementById('fieldTableBody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" class="form-control" data-key="label" placeholder="Contoh: Pilih Laminasi"></td>
        <td><input type="text" class="form-control" data-key="name" placeholder="laminasi"></td>
        <td>
            <div class="option-wrapper">
                <div class="d-flex mb-1 option-row">
                    <input type="text" class="form-control me-2 option-label" placeholder="Nama Opsi (misal: Glossy)">
                    <input type="number" class="form-control option-price" placeholder="Harga Tambahan" value="0">
                    <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeOption(this)">✕</button>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-1" onclick="addOption(this)">+ Opsi</button>
        </td>
        <td class="text-center">
            <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">Hapus</button>
        </td>
    `;
    tbody.appendChild(row);
    fieldIndex++;
}

function removeRow(button) {
    button.closest('tr').remove();
}

function addOption(button) {
    const wrapper = button.parentElement.querySelector('.option-wrapper');
    const optionRow = document.createElement('div');
    optionRow.classList.add('d-flex', 'mb-1', 'option-row');

    optionRow.innerHTML = `
        <input type="text" class="form-control me-2 option-label" placeholder="Nama Opsi">
        <input type="number" class="form-control option-price" placeholder="Harga Tambahan" value="0">
        <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeOption(this)">✕</button>
    `;
    wrapper.appendChild(optionRow);
}

function removeOption(button) {
    button.closest('.option-row').remove();
}

document.getElementById('productForm').addEventListener('submit', function () {
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

document.addEventListener('DOMContentLoaded', function () {
    addFormFieldRow();
});
</script>
@endpush
