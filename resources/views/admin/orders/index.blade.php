@extends('layouts.admin')

@section('title', 'Riwayat Pesanan')

@section('content')

{{-- BREADCRUMB --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb custom-breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"> Riwayat Pesanan</li>
    </ol>
</nav>

{{-- INFORMASI PELANGGAN --}}
<h5 class="heading">Riwayat Pesanan</h5>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    {{-- TABLE --}}
    <div class="table-responsive">
    <table class="table table-custom-font align-middle table-hover table-borderless shadow-sm rounded" style="border-radius: 12px; overflow: hidden;">
        <thead class="bg-light text-dark">
            <tr>
                <th style>No</th>
                <th style>Nama</th>
                <th style>Produk</th>
                <th style="width: 100px">Jumlah</th>
                <th style="width: 150px">Status</th>
                <th style>Waktu</th>
                <th style="width: 100px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="border-bottom">
                    <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                    <td>{{ $order->customer_name ?? '-' }}</td>
                    <td>{{ $order->product->name ?? '-' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>
    @php
    $badgeClass = match ($order->status) {
        'menunggu' => 'bg-menunggu',
        'diproses' => 'bg-process',
        'selesai' => 'bg-selesai',
        'dibatalkan' => 'bg-batal',
        default => 'bg-secondary',
    };
@endphp

<span class="badge {{ $badgeClass }}">
    {{ ucfirst($order->status) }}
</span>


</td>

                    <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="btn btn-tertiary btn-sm" title="Lihat Detail">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            <button class="btn btn-tertiary-danger btn-sm"
                                    onclick="showDeleteModal('{{ route('admin.orders.destroy', $order->id) }}')"
                                    title="Hapus">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        Belum ada pesanan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Paginasi -->
<div class="mt-4 d-flex justify-content-center">
    {{ $orders->links() }}
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
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
        <form id="deleteForm" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-hapus">Hapus</button>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();

    function showDeleteModal(actionUrl) {
        const deleteForm = document.getElementById('deleteForm');
        const modalElement = document.getElementById('confirmDeleteModal');

        if (!deleteForm || !modalElement) {
            console.error("Modal atau form tidak ditemukan.");
            return;
        }

        deleteForm.setAttribute('action', actionUrl);

        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }

    document.getElementById('toggleSidebar')?.addEventListener('click', function () {
        document.body.classList.toggle('sidebar-collapsed');
    });
</script>
@endpush
