@extends('layouts.admin')

@section('content')
<!-- Toggle Button (Responsive) -->
<button id="toggleSidebar" class="btn btn-outline-primary mb-3 d-md-none">
    <span data-feather="menu"></span>
</button>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
<nav id="sidebar" class="col-md-2 d-none d-md-block sidebar pt-4 custom-sidebar">
  <div class="sidebar-sticky px-3">
    <h6 class="sidebar-heading text-uppercase text-muted fw-bold small mb-4">Menu Admin</h6>
    <ul class="nav flex-column gap-1">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <span data-feather="home" class="me-2"></span> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
          <i class="bi bi-cart-check me-2"></i> Pesanan
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
          <i class="bi bi-box-seam me-2"></i> Produk
        </a>
      </li>
    </ul>
  </div>
</nav>


        <!-- Main Content -->
        <main id="mainContent" role="main" class="col-md-10 ml-sm-auto px-4 pt-3 bg-white">
           <div class="hero-card d-flex align-items-center p-4 mb-4 rounded shadow-sm">
    <div class="icon-wrapper me-3">
        <img src="{{ asset('images/dashboard/hero-img.svg') }}" alt="Dashboard" width="50" height="50">
    </div>
    <div>
        <h2 class="mb-1 fw-semibold">Hi Admin Dulur Setting!</h2>
        <p class="mb-0">Kelola pesanan dan produk pelanggan di sini.</p>
    </div>
</div>


            <h4 class="heading">Dashboard Admin</h4>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="summary-card">
                        <div class="pesanan-icon bg-pesanan">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div class="summary-value">{{ $totalOrders }}</div>
                        <div class="summary-label">Total Pesanan</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="summary-card">
                        <div class="produk-icon bg-produk">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div class="summary-value">{{ $totalProducts }}</div>
                        <div class="summary-label">Total Produk</div>
                    </div>
                </div>
            </div>

            <h4>Pesanan Terbaru</h4>
            <div class="table-responsive">
                <table class="table align-middle table-hover table-borderless shadow-sm rounded">
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
                                <span class="badge rounded-pill 
                                    {{ $order->status === 'selesai' ? 'bg-success' : 
                                        ($order->status === 'menunggu' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Lihat Detail">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger"
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

            <!-- resources/views/components/delete-modal.blade.php -->
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
        </main>
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

    document.getElementById('toggleSidebar').addEventListener('click', function () {
        document.body.classList.toggle('sidebar-collapsed');
    });
</script>
@endsection
