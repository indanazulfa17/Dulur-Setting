{{-- Form Cetak Mug --}}
<div class="mb-3">
    <label for="print_type" class="form-label">Tipe Cetak</label>
    <select name="print_type" id="print_type" class="form-control" required>
        <option value="1-sisi">1 Sisi</option>
        <option value="2-sisi">2 Sisi</option>
        <option value="wrap">Full Wrap</option>
    </select>
</div>

<div class="mb-3">
    <label for="color" class="form-label">Warna Mug</label>
    <select name="color" id="color" class="form-control" required>
        <option value="">-- Pilih Warna --</option>
        <option value="putih">Putih</option>
        <option value="hitam">Hitam</option>
        <option value="merah">Merah</option>
    </select>
</div>

<div class="mb-3">
    <label for="file" class="form-label">Upload Desain Mug</label>
    <input type="file" name="file" id="file" class="form-control" required accept=".jpg,.png,.pdf">
</div>

<div class="mb-3">
    <label for="quantity" class="form-label">Jumlah Mug</label>
    <input type="number" name="quantity" id="quantity" class="form-control" required>
</div>
