@extends('layouts.admin')

@section('content')

{{-- HERO --}}
<div class="mb-3">
    <div class="hero-card d-flex align-items-center p-4 mb-0 ">
        {{-- Hero Card --}}
        <div class="icon-wrapper me-4">
            <img src="{{ asset('images/dashboard/icon-img.png') }}" alt="Dashboard" width="40" height="40">
        </div>
        <div>
            <h2 class="mb-1 fw-semibold">Selamat datang kembali, Admin!</h2>
            <p class="mb-0">Kelola produk dan pesanan pelanggan di sini.</p>
        </div>
    </div>
</div>

{{-- TOTAL SECTION --}}
<h5 class="heading">Dashboard Admin</h5>
    <div class="row mb-3">
        {{-- Total Pesanan --}}
        <div class="col-md-4">
            <div class="summary-card">
                <div class="pesanan-icon bg-pesanan">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="summary-value">{{ $totalOrders }}</div>
                <div class="summary-label">Total Pesanan</div>
            </div>
        </div>
        {{-- Total Produk --}}
        <div class="col-md-4">
            <div class="summary-card">
                <div class="produk-icon bg-produk">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="summary-value">{{ $totalProducts }}</div>
                <div class="summary-label">Total Produk</div>
            </div>
        </div>
        {{-- Total Pelanggan --}}
        <div class="col-md-4">
            <div class="summary-card">
                <div class="pelanggan-icon bg-pelanggan">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="summary-value">{{ $totalUsers }}</div>
                <div class="summary-label">Total Pelanggan</div>
            </div>
        </div>
    </div>

{{-- PESANAN TERBARU SECTION --}}
<h5 class="heading">Pesanan Terbaru</h5>
    <div class="table-responsive">
        <table class="table table-custom-font align-middle table-hover table-borderless shadow-sm rounded" style="border-radius: 12px; overflow: hidden;">
            <thead class="bg-light text-dark">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestOrders as $order)
                <tr class="border-bottom">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->product->name ?? '-' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>
                        <span class="badge rounded {{ 
    $order->status === 'selesai' ? 'bg-selesai' : 
    ($order->status === 'menunggu' ? 'bg-menunggu' : 
    ($order->status === 'diproses' ? 'bg-process' : 'bg-process')) 
}}">
    {{ ucfirst($order->status) }}
</span>
                    </td>
                    <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-2">
                            {{-- Button Lihat --}}
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-tertiary btn-sm " title="Lihat Detail">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            {{-- Button Hapus --}}
                            <button class="btn btn-tertiary-danger btn-sm" onclick="showDeleteModal('{{ route('admin.orders.destroy', $order->id) }}')" title="Hapus">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i> Belum ada pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
<div class="text-end mt-2">
    <a href="{{ route('admin.orders.new') }}" class="btn btn-outline btn-sm">
        Lihat Semua Pesanan
    </a>
</div>
{{-- resources/views/components/delete-modal.blade.php --}}
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
</div>

@endsection

@section('scripts')
<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>

<!-- Bootstrap Bundle (WAJIB UNTUK MODAL) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    feather.replace();

    function showDeleteModal(actionUrl) {
        const deleteForm = document.getElementById('deleteForm');
        if (!deleteForm) {
            console.error("Form deleteForm tidak ditemukan");
            return;
        }
        deleteForm.setAttribute('action', actionUrl);

        const modalElement = document.getElementById('confirmDeleteModal');
        if (!modalElement) {
            console.error("Modal confirmDeleteModal tidak ditemukan");
            return;
        }

        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
document.addEventListener('DOMContentLoaded', function() {
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    console.log("sidebarCollapse:", sidebarCollapse);
    if(sidebarCollapse){
        sidebarCollapse.addEventListener('click', function() {
            console.log("Sidebar toggle clicked");
            document.body.classList.toggle('sidebar-collapsed');
        });
    }
});


</script>
@endsection
