@extends('layouts.admin')


@section('content')
{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb custom-breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"> Produk </li>
    </ol>
</nav>

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="heading">Daftar Produk</h5>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Tambah Produk</a>
</div>
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

{{-- Table Card --}}
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-0" style="border-radius: 12px;">
        <div class="table-responsive">
            <table class="table table-custom-font align-middle table-hover table-borderless shadow-sm mb-0" style="border-radius: 12px; overflow: hidden;">
                <thead class="bg-light text-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $i => $product)
                    <tr class="border-bottom">
                        <td>{{ $products->firstItem() + $i }}</td>

                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>Rp {{ number_format($product->base_price, 0, ',', '.') }}</td>
                        <td>
                            @if ($product->mainImage)
                                <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"alt="Gambar Produk" class="img-thumbnail shadow-sm" style="max-width: 70px;">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-tertiary-2 btn-sm" title="Edit Produk"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <button class="btn btn-tertiary-danger btn-sm" onclick="showDeleteModal('{{ route('admin.products.destroy', $product->id) }}')" title="Hapus Produk">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                            </div>
                        </td>
                    </tr>
                    
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-box-seam fs-4 d-block mb-2"></i> Belum ada produk yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Paginasi -->
<div class="mt-4 d-flex justify-content-center">
    {{ $products->links() }}
</div>
        </div>
    </div>
</div>
  

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-hapus text-danger">
        <i class="fa-solid fa-trash-can"></i>
      </div>
      <div class="modal-body text-center">
        <h5 class="modal-title mb-3" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
        <p>Yakin ingin menghapus item ini?</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
        <form id="deleteForm" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-hapus">Hapus</button>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
    function showDeleteModal(actionUrl) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.setAttribute('action', actionUrl);
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
</script>
@endpush
