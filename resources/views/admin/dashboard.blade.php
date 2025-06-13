@extends('layouts.admin')

@section('content')
<!-- Toggle Button (Responsive) -->
<button id="toggleSidebar" class="btn btn-outline-primary mb-3 d-md-none">
    <span data-feather="menu"></span>
</button>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-2 d-none d-md-block sidebar pt-3 custom-sidebar">
            <div class="sidebar-sticky px-3">
                <h6 class="sidebar-heading text-muted font-weight-bold small mb-4">Menu Admin</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <span data-feather="home"></span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-cart-check"></i><span data-feather="shopping-cart"></span> Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box-seam"></i><span data-feather="box"></span> Produk
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main id="mainContent" role="main" class="col-md-10 ml-sm-auto px-4 pt-3 bg-white">
            <div class="hero d-flex">
                <img src="{{ asset('images/dashboard/hero-img.svg') }}" alt="Pilih Produk" width="80px" height="80px">
                <div class="ms-4">
                    <h2 class="mb-2">Hi Admin Dulur Setting!</h2>
                    <p class="mb-2">Kelola pesanan dan produk pelanggan di sini.</p>
                </div>
            </div>

            <h4 class="heading">Dashboard Admin</h4>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="summary-card">
            <div class="pesanan-icon bg-pesanan">
                <i class="bi bi-cart-check"></i> {{-- Ganti sesuai ikon yang kamu pakai --}}
            </div>
            <div class="summary-value">{{ $totalOrders }}</div>
            <div class="summary-label">Total Pesanan</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="summary-card">
            <div class="produk-icon bg-produk">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="summary-value">{{ $totalProducts }}</div>
            <div class="summary-label">Total Produk</div>
        </div>
    </div>
</div>


            <h4>Pesanan Terbaru</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->product->name ?? '-' }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace(); // Untuk ikon feather

    document.getElementById('toggleSidebar').addEventListener('click', function () {
        document.body.classList.toggle('sidebar-collapsed');
    });
</script>
@endsection
