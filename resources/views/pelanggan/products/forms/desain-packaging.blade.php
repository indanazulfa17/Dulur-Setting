{{-- Form Desain Packaging --}}
<div class="mb-3">
    <label for="design_type" class="form-label">Jenis Desain</label>
    <select name="design_type" id="design_type" class="form-control" required>
        <option value="">-- Pilih --</option>
        <option value="box">Desain Box</option>
        <option value="label">Label Produk</option>
        <option value="kemasan">Kemasan Makanan</option>
    </select>
</div>

<div class="mb-3">
    <label for="custom_description" class="form-label">Detail Desain</label>
    <textarea name="custom_description" id="custom_description" class="form-control" rows="5" placeholder="Contoh: Warna dominan, tema, ukuran, dll."></textarea>
</div>

<div class="mb-3">
    <label for="file" class="form-label">Upload Referensi (opsional)</label>
    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.jpg,.png">
</div>

<div class="mb-3">
    <label for="quantity" class="form-label">Jumlah Item yang Didukung</label>
    <input type="number" name="quantity" id="quantity" class="form-control" required>
</div>
