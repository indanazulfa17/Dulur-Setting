{{-- Form Cetak Brosur --}}
<div class="mb-3">
    <label for="material" class="form-label">Pilih Bahan Kertas</label>
    <select name="material_id" id="material" class="form-control" required>
        <option value="">-- Pilih Bahan --</option>
        @foreach ($materials as $material)
            <option value="{{ $material->id }}" data-price="{{ $material->additional_price }}">
                {{ $material->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="size" class="form-label">Ukuran</label>
    <select name="size_id" id="size" class="form-control" required>
        <option value="">-- Pilih Ukuran --</option>
        @foreach ($sizes as $size)
            <option value="{{ $size->id }}" data-price="{{ $size->additional_price }}">
                {{ $size->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="lamination" class="form-label">Laminasi (Opsional)</label>
    <select name="lamination_id" id="lamination" class="form-control">
        <option value="">-- Tidak Dilaminasi --</option>
        @foreach ($laminations as $lamination)
            <option value="{{ $lamination->id }}" data-price="{{ $lamination->additional_price }}">
                {{ $lamination->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="folding" class="form-label">Jenis Lipatan</label>
    <select name="folding" id="folding" class="form-control">
        <option value="">-- Pilih --</option>
        <option value="tidak">Tanpa Lipatan</option>
        <option value="2-lipatan">2 Lipatan</option>
        <option value="3-lipatan">3 Lipatan</option>
    </select>
</div>

<div class="mb-3">
    <label for="quantity" class="form-label">Jumlah</label>
    <input type="number" name="quantity" id="quantity" class="form-control" required>
</div>

<div class="mb-3">
    <label for="file" class="form-label">Upload File Desain</label>
    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
</div>
