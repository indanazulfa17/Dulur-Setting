@extends('layouts.admin')

@section('content')

    {{-- Breadcrumb --}}
    <a href="{{ route('admin.products.index') }}" class="breadcrumb-back-link mb-3 d-inline-block">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Produk
    </a>

    {{-- Heading --}}
    <h5 class="heading">Tambah Produk Baru</h5>
    
    {{-- Allert --}}
    <div id="formAlert" class="alert alert-danger d-none">
        Field belum diisi semua. Silakan periksa kembali.
    </div>

    <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informasi Produk --}}
        <div class="card mb-4">
            <div class="card-head">
                Informasi Produk
            </div>
            <div class="card-body">
                <div class="form">
                    <label class="form-label">Nama Produk<span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Kartu Nama" required>
                </div>

                <div class="form">
                    <label class="form-label">Deskripsi<span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Deskripsikan produk" required></textarea>
                </div>

                <div class="form">
                    <label class="form-label">Gambar Produk<span class="text-danger">*</span></label>
                    <input type="file" name="images[]" class="form-control" id="imageInput" multiple required>
                    <div id="imagePreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class= "form">
                        <label class="form-label">Kategori<span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class= "form">
                        <label class="form-label">Harga Dasar (Rp)<span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="0" required>
                        </div>
                    </div>
                </div>   
            </div>
        </div>

        {{-- Bahan --}}
        <div class="card mb-4">
            <div class="card-head ">Bahan</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle rounded table-borderless" id="materialTable">
                        <thead class="bg-light">
                            <tr>
                                <th>
                                    <label class="table-label">Nama Bahan <span class="text-danger">*</span></label>
                                </th>
                                <th>
                                    <label class="table-label">Harga Tambahan (Rp)</label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="new_materials[0][name]" class="form-control" placeholder="Contoh: Art Paper" required></td>
                                <td><input type="number" name="new_materials[0][additional_price]" class="form-control" value="0"></td>
                                <td class="text-center">
                                    <button class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)"><i class="fa-regular fa-trash-can"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <button type="button" onclick="addMaterialRow()" class="btn-outline btn-md">
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
                                <th>
                                    <label class="table-label">Nama Ukuran <span class="text-danger">*</span></label>
                                </th>
                                <th>
                                    <label class="table-label">Dimensi</label>
                                </th>
                                <th>
                                    <label class="table-label">Harga Tambahan (Rp)</label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="new_sizes[0][name]" class="form-control" placeholder="Contoh: A5" required></td>
                                <td><input type="text" name="new_sizes[0][dimension]" class="form-control" placeholder="Contoh: 14.8 x 21 cm"></td>
                                <td><input type="number" name="new_sizes[0][additional_price]" class="form-control" value="0"></td>
                                <td class="text-center">
                                    <button class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)"><i class="fa-regular fa-trash-can"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <button type="button" onclick="addSizeRow()" class="btn-outline btn-md">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Ukuran
                    </button>
                </div>
        </div>

        
        {{-- Laminasi --}}
        <div class="card mb-4">
            <div class="card-head ">Laminasi</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle rounded table-borderless" id="laminationTable">
                        <thead class="bg-light">
                            <tr>
                                <th>
                                    <label class="table-label">Jenis Laminasi <span class="text-danger">*</span></label>
                                </th>
                                <th>
                                    <label class="table-label">Harga Tambahan (Rp)</label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="new_laminations[0][name]" class="form-control" placeholder="Contoh: Glossy" required></td>
                                <td><input type="number" name="new_laminations[0][additional_price]" class="form-control" value="0"></td>
                                <td class="text-center">
                                    <button class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)"><i class="fa-regular fa-trash-can"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <button type="button" onclick="addLaminationRow()" class="btn-outline btn-md">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Laminasi
                    </button>
                </div>
        </div>
        
        {{-- Field Tambahan (Opsional) --}}
        <div class="card mb-4">
            <div class="card-head"> Field Tambahan (Opsional) </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle rounded table-borderless" id="customFieldTable">
                        <thead class="bg-light">
                            <tr>
                                <th><label class="table-label">Label </label></th>
                                <th><label class="table-label">Nama Input </label></th>
                                <th><label class="table-label">Opsi dan Harga </label></th>
                            </tr>
                        </thead>
                        <tbody id="fieldTableBody">
                            <!-- Baris akan ditambahkan dengan JavaScript -->
                        </tbody>
                    </table>
                </div>
                    <button type="button" onclick="addFormFieldRow()" class="btn-outline btn-md">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Field
                    </button>
                    <input type="hidden" name="form_fields_json" id="form_fields_json">
                </div>
            </div>
        
        <!-- Button Simpan Produk -->
        <div class="text-end mt-4">
            <button type="button" class="btn btn-primary btn-md" onclick="handleBeforeSubmit()">Simpan Produk</button>
        </div>
    </form>

    <!-- Modal Konfirmasi Simpan Produk -->
<div class="modal fade" id="modalConfirmSubmit" tabindex="-1" aria-labelledby="modalConfirmSubmitLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-simpan">
        <i class="fa-solid fa-trash-can"></i>
      </div>
      <div class="modal-body text-center">
        <h5 class="modal-title mb-3">Konfirmasi Simpan Produk</h5>
        <p>Apakah kamu yakin ingin menyimpan produk ini?</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-simpan" onclick="submitProductForm()">Ya, Simpan</button>
      </div>
    </div>
  </div>
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
        <td class="text-center"><button class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)"><i class="fa-regular fa-trash-can"></i></button></td>
    `;
    table.appendChild(row);
    materialIndex++;
}

function addSizeRow() {
    const table = document.getElementById('sizeTable').querySelector('tbody');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td><input type="text" name="new_sizes[${sizeIndex}][name]" class="form-control" required></td>
        <td><input type="text" name="new_sizes[${sizeIndex}][dimension]" class="form-control"></td>
        <td><input type="number" name="new_sizes[${sizeIndex}][additional_price]" class="form-control" value="0"></td>
        <td class="text-center"><button class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)"><i class="fa-regular fa-trash-can"></i></button></td>
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
        <td class="text-center"><button class="btn btn-tertiary-danger btn-sm" onclick="removeRow(this)"><i class="fa-regular fa-trash-can"></i></button></td>
    `;
    table.appendChild(row);
    laminationIndex++;
}

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
            <button type="button" onclick="addOption(this)" class="btn-outline-2 btn-md " >
                <i class="fa-solid fa-circle-plus"></i> Opsi
            </button> 
        </td>
        <td class="align-top text-center py-2">
            <button class="btn btn-tertiary-danger btn-sm" title="Hapus field ini" onclick="removeRow(this)">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </td>
    `;
    tbody.appendChild(row);
    fieldIndex++;
}



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

function removeOption(button) {
    button.closest('.option-row').remove();
}


function removeOption(button) {
    button.closest('.option-row').remove();
}

function removeRow(button) {
    const row = button.closest('tr');
    if (row) {
        row.remove();
    }
}
function handleBeforeSubmit() {
    const form = document.getElementById('productForm');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    let firstInvalid = null;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            if (!firstInvalid) {
                firstInvalid = field;
            }
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

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

    const modal = new bootstrap.Modal(document.getElementById('modalConfirmSubmit'));
    modal.show();
}


function submitProductForm() {
    // Generate field tambahan ke form_fields_json sebelum submit
    const rows = document.querySelectorAll('#fieldTableBody tr');
    const result = [];

    rows.forEach(row => {
        const label = row.querySelector('[data-key="label"]').value.trim();
        const name = row.querySelector('[data-key="name"]').value.trim();

        const options = [];
        row.querySelectorAll('.option-row').forEach(opt => {
            const optLabel = opt.querySelector('.option-label').value.trim();
            const optPriceInput = opt.querySelector('.option-price').value.trim();
const optPrice = optPriceInput === '' ? 0 : parseFloat(optPriceInput);


            if (optLabel) {
                options.push({ label: optLabel, price: optPrice });
            }
        });

        if (label && name && options.length > 0) {
            result.push({ label: label, name: name, type: "select", options: options });
        }
    });

    document.getElementById('form_fields_json').value = JSON.stringify(result);

    // Submit form setelah input hidden terisi
    document.getElementById('productForm').submit();
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
            const optPriceInput = opt.querySelector('.option-price').value.trim();
const optPrice = optPriceInput === '' ? 0 : parseFloat(optPriceInput);


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

document.getElementById('imageInput').addEventListener('change', function (event) {
    const previewContainer = document.getElementById('imagePreview');
    previewContainer.innerHTML = ''; // Bersihkan preview sebelumnya

    const files = event.target.files;

    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.maxWidth = '150px';
            img.style.maxHeight = '150px';
            img.style.objectFit = 'cover';
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
