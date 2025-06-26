@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Edit Produk</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label fw-semibold">Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $product->base_price) }}" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Kategori</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <h5 class="fw-bold">Gambar Produk</h5>
            @forelse ($product->images as $index => $image)
                <div class="row mb-3 align-items-center">
                    <div class="col-md-2">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail shadow-sm" width="100">
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" name="existing_images[{{ $index }}][id]" value="{{ $image->id }}">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="existing_images[{{ $index }}][delete]" value="1" id="deleteImage{{ $index }}">
                            <label class="form-check-label text-danger" for="deleteImage{{ $index }}">
                                Hapus gambar ini
                            </label>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada gambar</p>
            @endforelse
        </div>

        <div class="mb-5">
            <label class="form-label fw-semibold">Tambah Gambar Baru</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
        </div>

        <div class="mb-4">
            <h5 class="fw-bold">Bahan</h5>
        @forelse ($product->materials as $index => $material)
            <div class="row mb-2 align-items-center">
                <input type="hidden" name="materials[{{ $index }}][id]" value="{{ $material->id }}">
                <div class="col-md-4">
                    <input type="text" name="materials[{{ $index }}][name]" class="form-control bg-light" value="{{ $material->name }}" readonly>
                </div>
                <div class="col-md-4">
                    <input type="number" name="materials[{{ $index }}][additional_price]" class="form-control" value="{{ $material->pivot->additional_price }}">
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="materials[{{ $index }}][delete]" value="1" id="deleteMaterial{{ $index }}">
                        <label class="form-check-label text-danger" for="deleteMaterial{{ $index }}">
                            Hapus
                        </label>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada bahan</p>
        @endforelse
        

         <div class="mb-5">
            
            <div id="newMaterialsContainer"></div>
            <button type="button" onclick="addNewMaterial()" class="btn btn-outline-primary btn-sm"> + Tambah Bahan</button>
        </div>
        </div>

        
        <div class="mb-4">
            <h5 class="fw-bold">Ukuran</h5>
            @forelse ($product->sizes as $index => $size)
                <div class="row mb-2">
                    <input type="hidden" name="sizes[{{ $index }}][id]" value="{{ $size->id }}">
                    <div class="col-md-3">
                        <input type="text" name="sizes[{{ $index }}][name]" class="form-control" value="{{ $size->name }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="sizes[{{ $index }}][dimension]" class="form-control" value="{{ $size->dimension }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="sizes[{{ $index }}][additional_price]" class="form-control" value="{{ $size->pivot->additional_price }}">
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sizes[{{ $index }}][delete]" value="1" id="deleteSize{{ $index }}">
                            <label class="form-check-label text-danger" for="deleteSize{{ $index }}">
                                Hapus
                            </label>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada ukuran</p>
            @endforelse
        </div>

        <div id="newSizesContainer" class="mb-4"></div>
        <button type="button" onclick="addNewSize()" class="btn btn-link text-primary px-0">+ Tambah Ukuran</button>

        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn btn-primary px-4">Perbarui Produk</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4">Kembali</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let materialIndex = 0;
    let sizeIndex = 0;

    function addNewMaterial() {
        const html = `
            <div class="row mb-2">
                <div class="col-md-4">
                    <input type="text" name="new_materials[${materialIndex}][name]" class="form-control" placeholder="Nama Material">
                </div>
                <div class="col-md-4">
                    <input type="number" name="new_materials[${materialIndex}][additional_price]" class="form-control" placeholder="Harga Tambahan">
                </div>
            </div>`;
        document.getElementById('newMaterialsContainer').insertAdjacentHTML('beforeend', html);
        materialIndex++;
    }

    function addNewSize() {
        const html = `
            <div class="row mb-2">
                <div class="col-md-3">
                    <input type="text" name="new_sizes[${sizeIndex}][name]" class="form-control" placeholder="Nama Ukuran">
                </div>
                <div class="col-md-3">
                    <input type="text" name="new_sizes[${sizeIndex}][dimension]" class="form-control" placeholder="Dimensi">
                </div>
                <div class="col-md-3">
                    <input type="number" name="new_sizes[${sizeIndex}][additional_price]" class="form-control" placeholder="Harga Tambahan">
                </div>
            </div>`;
        document.getElementById('newSizesContainer').insertAdjacentHTML('beforeend', html);
        sizeIndex++;
    }
</script>
@endpush