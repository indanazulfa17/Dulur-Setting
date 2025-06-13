
@extends('layouts.pelanggan')

@section('pelanggan.products.show')

@section('content')


    <h1>Daftar Produk</h1>

    @foreach ($products as $product)
        <div>
            <h2>{{ $product->name }}</h2>
            <p>Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <a href="{{ route('pelanggan.products.show', $product->id) }}">Lihat Detail</a>
        </div>
    @endforeach
    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm">
  @csrf
  <input type="hidden" name="product_id" value="{{ $produk->id }}">

  <div class="row g-3">
    <!-- Ukuran -->
    <div class="col-md-6">
      <label for="size_id" class="form-label">Ukuran</label>
      <select name="size_id" id="size_id" class="form-select" required>
        <option value="" disabled selected>Pilih Ukuran</option>
        @foreach($sizes as $size)
          <option value="{{ $size->id }}">{{ $size->name }}</option>
        @endforeach
      </select>
    </div>

    <!-- Jumlah -->
    <div class="col-md-6">
      <label for="quantity" class="form-label">Jumlah (pcs)</label>
      <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
    </div>

    <!-- Bahan -->
    <div class="col-md-6">
      <label for="material_id" class="form-label">Bahan</label>
      <select name="material_id" id="material_id" class="form-select" required>
        <option value="" disabled selected>Pilih Bahan</option>
        @foreach($materials as $material)
          <option value="{{ $material->id }}">{{ $material->name }}</option>
        @endforeach
      </select>
    </div>

    <!-- Laminasi -->
    <div class="col-md-6">
      <label for="lamination_id" class="form-label">Laminasi</label>
      <select name="lamination_id" id="lamination_id" class="form-select" required>
        <option value="" disabled selected>Pilih Laminasi</option>
        @foreach($laminations as $lamination)
          <option value="{{ $lamination->id }}">{{ $lamination->name }}</option>
        @endforeach
      </select>
    </div>

    <!-- File Desain -->
    <div class="col-md-12">
      <label for="design_file" class="form-label">Upload File Desain</label>
      <input type="file" name="design_file" id="design_file" class="form-control" accept=".pdf,.png,.jpg" required>
    </div>

    <!-- Submit -->
    <div class="col-md-12 text-end">
      <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
    </div>
  </div>
</form>

@endsection

