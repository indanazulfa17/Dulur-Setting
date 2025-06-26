@extends('layouts.admin')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container-fluid px-4 mt-4">
    <h4>Riwayat Pesanan</h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->customer_name ?? '-' }}</td>
                        <td>{{ $order->product->name ?? '-' }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                    <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $order->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="btn btn-sm btn-primary" title="Lihat">
                                    Lihat
                                </a>
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="showDeleteModal('{{ route('admin.orders.destroy', $order->id) }}')"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus pesanan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
