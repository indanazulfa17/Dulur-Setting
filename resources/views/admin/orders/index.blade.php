@extends('layouts.admin')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container-fluid mt-5">
    <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb custom-breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
             Riwayat Pesanan
        </li>
    </ol>
</nav>

    <h4>Riwayat Pesanan</h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="table-responsive">
    <table class="table align-middle table-hover table-borderless shadow-sm rounded">
        <thead class="bg-light text-dark">
            <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 150px;">Nama</th>
                <th style="width: 180px;">Produk</th>
                <th style="width: 100px;">Jumlah</th>
                <th style="width: 120px;" >Status</th>
                <th style="width: 120px;" >Waktu</th>
                <th style="width: 100px;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="border-bottom">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->customer_name ?? '-' }}</td>
                    <td>{{ $order->product->name ?? '-' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>
    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <select name="status" onchange="this.form.submit()"
            class="form-select form-select-sm rounded-pill w-auto py-1 px-5
            {{ $order->status === 'selesai' ? 'bg-white text-dark' : 
                ($order->status === 'diproses' ? 'bg-white text-dark' : 'bg-secondary text-dark') }}">
            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </form>
</td>

                    <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="btn btn-sm btn-outline-primary" title="Lihat Detail">
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
          <button type="submit" class="btn btn-hapus">Hapus</button>
        </form>
      </div>
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
