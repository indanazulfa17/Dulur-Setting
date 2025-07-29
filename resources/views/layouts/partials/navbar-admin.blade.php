{{--TOP BAR --}}
<nav class="navbar navbar-expand-lg bg-white shadow-sm px-0 py-2 fixed-top">
    <div class="navbar d-flex align-items-center justify-content-between w-100">
        {{-- Logo --}}
        <div class="d-flex align-items-center gap-2">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100" height="40" class="me-2">
            </a>
        </div>
        {{-- Button Logout --}}
<div class="d-flex align-items-center gap-3">
  <button type="button" class="btn-outline-danger btn-md" onclick="showLogoutModal()">
    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
  </button>
</div>

    </div>
</nav>

{{-- SIDEBAR --}}
<nav id="sidebar" class="sidebar px-5 py-3">
    <div class="d-flex flex-column h-100">
        {{-- Logo --}}
        <div class=" d-flex justify-content-between align-items-center px-3 py-3">
            <p class="nav-brand mb-0">Menu Admin</p>
        </div>
        {{-- Menu List --}}
        <ul class="nav flex-column mt-3 px-0">
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center gap-2 py-2  {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            {{-- Pesanan (Dropdown) --}}
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center justify-content-between py-2 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#submenuOrders" role="button"
                   aria-expanded="{{ request()->routeIs('admin.orders.*') ? 'true' : 'false' }}" aria-controls="submenuOrders">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-cart-shopping"></i> <span>Pesanan</span>
                    </div>
                    <i class="chevron-icon fa-solid small" aria-hidden="true"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.orders.*') ? 'show' : '' }}" id="submenuOrders">
                    <ul class="nav flex-column ms-4 mt-2">
                        <li class="nav-item mb-2">
                            <a class="nav-link d-flex align-items-center gap-2 py-2 {{ request()->routeIs('admin.orders.new') ? 'active' : '' }}" href="{{ route('admin.orders.new') }}">
                                <span>Pesanan Baru</span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link d-flex align-items-center gap-2 py-2 {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <span>Riwayat Pesanan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li class="nav-item mb-2">
                <a class="nav-link d-flex align-items-center justify-content-between py-2  {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#submenuProducts" role="button"
                    aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}" aria-controls="submenuProducts">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-box-open"></i> <span>Produk</span>
                    </div>
                    <i class="chevron-icon fa-solid small" aria-hidden="true"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="submenuProducts">
                    <ul class="nav flex-column ms-4 mt-2">
                        <li class="nav-item mb-2">
                            <a class="nav-link d-flex align-items-center gap-2 py-2 {{ request()->routeIs('admin.products.index') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                                 <span>Daftar Produk</span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link d-flex align-items-center gap-2 py-2 {{ request()->routeIs('admin.products.create') ? 'active' : '' }}" href="{{ route('admin.products.create') }}">
                                <span>Tambah Produk</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
