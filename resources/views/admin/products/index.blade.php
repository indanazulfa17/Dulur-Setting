@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb custom-breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
             Produk
        </li>
    </ol>
</nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar Produk</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $i => $product)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td>Rp {{ number_format($product->base_price, 0, ',', '.') }}</td>
                                <td>
                                    @if ($product->mainImage)
                                        <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                                            alt="Gambar Produk"
                                            class="img-thumbnail shadow-sm" style="max-width: 70px;">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                           class="btn btn-tertiary-2 btn-sm" title="Edit Produk">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button class="btn btn-tertiary-danger btn-sm"
                                                onclick="showDeleteModal('{{ route('admin.products.destroy', $product->id) }}')"
                                                title="Hapus Produk">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-box-seam fs-3 d-block mb-2"></i>
                                    Belum ada produk yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-hapus text-danger">
        <i class="bi bi-trash-fill"></i>
      </div>
      <div class="modal-body text-center">
        <h5 class="modal-title mb-3" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
        <p>Yakin ingin menghapus item ini?</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">Batal</button>
        <form id="deleteForm" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-hapus">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<!-- Bootstrap JS wajib agar modal bisa jalan -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function showDeleteModal(actionUrl) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.setAttribute('action', actionUrl);
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
</script>
@endpush
