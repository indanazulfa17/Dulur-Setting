@extends('layouts.pelanggan') {{-- atau layout yang kamu pakai --}}

@section('content')
    <h1 class="mb-4">Daftar Produk</h1>

    @foreach ($products as $product)
        <div class="mb-5 p-4 border rounded shadow-sm">
            <h2>{{ $product->name }}</h2>
            <p>Harga: Rp {{ number_format($product->base_price ?? $product->price, 0, ',', '.') }}</p>
            <a href="{{ route('pelanggan.products.show', $product->id) }}" class="btn btn-info mb-3">Lihat Detail</a>

            {{-- Form Pemesanan untuk produk ini --}}
            <form action="{{ route('pelanggan.products.preorder', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="row g-3">

                    <!-- Ukuran -->
                    <div class="col-md-6">
                        <label for="size_id_{{ $product->id }}" class="form-label">Ukuran</label>
                        <select name="size_id" id="size_id_{{ $product->id }}" class="form-select" required>
                            <option value="" disabled selected>Pilih Ukuran</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jumlah -->
                    <div class="col-md-6">
                        <label for="quantity_{{ $product->id }}" class="form-label">Jumlah (pcs)</label>
                        <input type="number" name="quantity" id="quantity_{{ $product->id }}" class="form-control" min="1" required>
                    </div>

                    <!-- Bahan -->
                    <div class="col-md-6">
                        <label for="material_id_{{ $product->id }}" class="form-label">Bahan</label>
                        <select name="material_id" id="material_id_{{ $product->id }}" class="form-select" required>
                            <option value="" disabled selected>Pilih Bahan</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Laminasi -->
                    <div class="col-md-6">
                        <label for="lamination_id_{{ $product->id }}" class="form-label">Laminasi</label>
                        <select name="lamination_id" id="lamination_id_{{ $product->id }}" class="form-select" required>
                            <option value="" disabled selected>Pilih Laminasi</option>
                            @foreach($laminations as $lamination)
                                <option value="{{ $lamination->id }}">{{ $lamination->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- File Desain -->
                    <div class="col-md-12">
                        <label for="design_file_{{ $product->id }}" class="form-label">Upload File Desain</label>
                        <input type="file" name="design_file" id="design_file_{{ $product->id }}" class="form-control" accept=".pdf,.png,.jpg" required>
                    </div>

                    <!-- Submit -->
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                    </div>

                </div>
            </form>
        </div>
    @endforeach
@endsection
