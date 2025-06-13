@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Daftar Produk</h2>

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">
        + Tambah Produk
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $i => $product)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>Rp {{ number_format($product->base_price, 0, ',', '.') }}</td>
                <td>
                   
                  @if ($product->mainImage)
    <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" width="80">
@else
    Tidak ada
@endif

                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
