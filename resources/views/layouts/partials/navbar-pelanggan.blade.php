{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg bg-white shadow-md py-3 position-relative">
  <div class="container d-flex align-items-center justify-content-between w-100">
    {{-- Logo --}}
    <a class="navbar-brand d-flex align-items-center" href="{{ route('pelanggan.beranda') }}">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100px" height="40px">
    </a>
    {{-- Togle (Mobile) --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Navbar Content --}}
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-4">
        <li class="nav-item">
          <a class="nav-link {{ Route::is('pelanggan.beranda') ? 'active' : '' }}" href="{{ route('pelanggan.beranda') }}">Beranda</a>
        </li>
        {{-- Mega Menu Produk --}}
        <li class="nav-item dropdown position-static">
          <a class="nav-link fw-medium d-flex align-items-center" href="#" id="produkDropdown"> Produk <i class="fa fa-chevron-down fa-sm align-middle ms-1"></i></a>
          <div class="mega-menu shadow-lg">
            <div class="row w-100">
              @foreach ($produkNavbar->groupBy('category.name') as $kategori => $produkGroup)
              <div class="col-md-3">
                <h6 class="mega-menu-judul">{{ $kategori }}</h6>
                <ul class="list-unstyled mega-menu-list">
                @foreach ($produkGroup as $produk)
                  <li>
                    <a href="{{ route('pelanggan.products.show', $produk->id) }}" class="mega-link">{{ $produk->name }}</a>
                  </li>
                @endforeach
                </ul>
              </div>
              @endforeach
            </div>
          </div>
        </li>
        {{-- Tentang Kami --}}
        <li class="nav-item"><a class="nav-link {{ Route::is('pelanggan.tentang') ? 'active' : '' }}"
          href="{{ route('pelanggan.tentang') }}">Tentang Kami</a>
        </li>
        {{-- Kontak --}}
        <li class="nav-item"><a class="nav-link {{ Route::is('pelanggan.kontak') ? 'active' : '' }}"
          href="{{ route('pelanggan.kontak') }}">Kontak</a>
        </li>
      </ul>
      {{-- Button Hubungi Kami --}}
      <div>
        <a href="https://wa.me/62895612811600" class="btn btn-primary btn-md">
          <i class="bi bi-whatsapp"></i> Hubungi Kami
        </a>
      </div>
    </div>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.mega-menu-list').forEach(list => {
    const items = Array.from(list.children);
    if (items.length <= 6) return;

    const wrapper = document.createElement('div');
    wrapper.classList.add('mega-menu-list-wrapper');

    for (let i = 0; i < items.length; i += 6) {
      const ul = document.createElement('ul');
      items.slice(i, i + 6).forEach(li => ul.appendChild(li));
      wrapper.appendChild(ul);
    }

    list.parentNode.replaceChild(wrapper, list);
  });
});
</script>

