@extends('layouts.pelanggan')

@section('title', 'home')

@section('content')


{{-- HERO SECTION --}}
<section class="hero position-relative">
  <div class="container">
    {{-- Summary Hero --}}
    <div class="row align-items-center">
      <div class="col-lg-10 hero-text fade-up">
        <h5>Selamat datang di Dulur Setting</h5>
        <div class="display">Solusi Percetakan Terpercaya</div>
        <br><p>Wujudkan ide Anda jadi cetakan berkualitas mudah, cepat, dan tanpa ribet dengan layanan Dulur Setting. Buat promosi usaha anda jadi mudah.</p>
        <a href="#layanan" class="btn btn-secondary btn-md"> Lihat Layanan <i class="fa-solid fa-circle-chevron-down"></i></a>
      </div>
    </div>
  </div>
</section>

{{-- LAYANAN SECTION --}}
<section id="layanan" class="layanan py-10">
  <div class="container text-center">
    {{-- Summary Layanan --}}
    <h5 class="heading">Layanan Kami</h5>
    <h4 class="sub-heading">Layanan Percetakan Berkualitas untuk Berbagai Kebutuhan</h4>
    <p class="desc">Temukan layanan cetak yang kamu butuhkan di sini, dengan beragam pilihan.</p>
    {{-- Search Bar --}}
    <div class="row justify-content-center mb-3">
      <div class="col-md-6 col-lg-7">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0 rounded-pill-start">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" id="searchInput" class="form-control rounded-pill-start border-start-0" placeholder="Cari Produk...">
         </div>
      </div>
    </div> 
    {{-- Dataset Layanan --}}
    <div class="row justify-content-center">
      <div class="col-lg-12">
        {{-- Filter Button --}}
        <div class="filter-wrapper">
          
          <div class="filter-buttons mb-4">
            <button class="btn btn-outline-custom active me-2" onclick="filterCategory('all', this)">Semua</button>
            <button class="btn btn-outline-custom me-2" onclick="filterCategory('percetakan', this)">Percetakan</button>
            <button class="btn btn-outline-custom me-2" onclick="filterCategory('digital-printing', this)">Digital Printing</button>
            <button class="btn btn-outline-custom me-2" onclick="filterCategory('advertising', this)">Advertising</button>
          </div>
          
        </div>
        {{-- Product Grid --}}
        <div id="productGrid" class="row "></div>
        {{-- Button Lihat Lainnya --}}
        <div class="d-flex justify-content-center mt-4">
          <button class="btn btn-outline" onclick="loadMore()">Lihat Lainnya</button>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- LAYANAN DESAIN GRAFIS --}}
<section class="container layanan-desain">
  <div class="container-content" data-animate>
    {{-- Summary --}}
    <h4 class="sub-heading">Butuh bantuan mendesain?</h4>
    <p> Ingin desain sesuai keinginanmu? Bisa! Dulur Setting menyediakan layanan jasa desain grafis, termasuk desain kustom. Konsultasikan kebutuhanmu, dan kami siap bantu mewujudkannya lewat WhatsApp.</p>
    <a href="https://wa.me/62895612811600" class="btn btn-secondary btn-md">
      <i class="bi bi-whatsapp"></i> Konsultasikan via WhatsApp
    </a>
  </div>
</section>

{{-- KENAPA KAMI SECTION --}}
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      {{-- Dataset Card --}}
      <div class="col-md-4" data-animate>
        <div class="card feature-card text-justify h-100">
          <img src="{{ asset('images/kenapa-kami/why-us-icon1.png') }}" alt="Icon" class="feature-icon">
          <div class="feature-title">Kualitas Terjamin</div>
          <div class="feature-desc">
            Kami menggunakan mesin percetakan canggih dan bahan berkualitas untuk memastikan kepuasan setiap pelanggan.
          </div>
        </div>
      </div>
      <div class="col-md-4" data-animate>
        <div class="card feature-card text-justify h-100">
          <img src="{{ asset('images/kenapa-kami/why-us-icon2.png') }}" alt="Icon" class="feature-icon">
          <div class="feature-title">Pelayanan Cepat dan Responsif</div>
          <div class="feature-desc">
            Tim yang profesional dan responsif memudahkan pelanggan untuk melakukan konsultasi desain, revisi, hingga proses cetak secara efisien.
          </div>
        </div>
      </div>
      <div class="col-md-4" data-animate>
        <div class="card feature-card text-justify h-100">
          <img src="{{ asset('images/kenapa-kami/why-us-icon3.png') }}" alt="Icon" class="feature-icon">
          <div class="feature-title">Harga Terjangkau</div>
          <div class="feature-desc">
            Menawarkan layanan cetak berkualitas dengan harga yang pas di kantong, cocok untuk kebutuhan pribadi maupun bisnis.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- LANGKAH PEMESANAN SECTION --}}
<div class="container langkah-section">
  <div class="row align-items-center">
    {{-- Summary --}}
    <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-delay="100" data-aos-offset="200">
      <img src="{{ asset('images/cara-pemesanan/image.png') }}" alt="Cara Pemesanan" class="img-fluid">
    </div>
    {{-- Dataset Langkah --}}
    <div class="col-md-6" data-aos="fade-left" data-aos-delay="200" data-aos-offset="200">
      {{-- Heading --}}
      <h5 class="heading">Cara Pemesanan</h5>
      <h4 class="sub-heading">Langkah Mudah Cetak Online</h4>
      <p class="desc">Tentukan produk yang ingin Anda cetak sebelum mengunggah file</p>
      {{-- Langkah-Langkah --}}
      <div class="step-item d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="icon-wrapper">
          <img src="{{ asset('images/cara-pemesanan/icon-1.png') }}" alt="Pilih Produk">
        </div>
        <div class="step-text ms-3">
          <p class="step-title fw-bold mb-1">1. Pilih Produk</p>
          <p class="step-description mb-0">Temukan produk cetak sesuai dengan kebutuhan Anda pada layanan kami.</p>
        </div>
      </div>
      <div class="step-item d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="icon-wrapper">
          <img src="{{ asset('images/cara-pemesanan/icon-2.png') }}" alt="Custom Desain">
        </div>
        <div class="step-text ms-3">
          <p class="step-title fw-bold mb-1">2. Custom Design</p>
          <p class="step-description mb-0">Isi detail pesanan : ukuran, bahan, jumlah, dan unggah file desain yang ingin dicetak. Selain itu, kamu juga bisa cek harga.</p>
        </div>
      </div>
      <div class="step-item d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="icon-wrapper">
          <img src="{{ asset('images/cara-pemesanan/icon-3.png') }}" alt="Custom Desain">
        </div>
        <div class="step-text ms-3">
          <p class="step-title fw-bold mb-1">3. Konfirmasi Pesanan</p>
          <p class="step-description mb-0">Lihat detail pesanan anda, kemudian isi form : nama lengkap, no whatsapp, dan metode pengambilan.</p>
        </div>
      </div>
      <div class="step-item d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="icon-wrapper">
          <img src="{{ asset('images/cara-pemesanan/icon-4.png') }}" alt="Custom Desain">
        </div>
        <div class="step-text ms-3">
          <p class="step-title fw-bold mb-1">4. Pembayaran</p>
          <p class="step-description mb-0">Upload bukti pembayaran ke rekening tertuju dan klik "Konfirmasi Sekarang" maka pesanan otomatis masuk ke dashboard admin dan info lanjut akan diarahkan ke WhatsApp.</p>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- KLIEN SECTION --}}
<section class="klien-section">
  <div class="container text-center">
    {{-- Summary Klien --}}
    <h5 class="heading">Klien Kami</h5>
    <h4 class="sub-heading">Klien yang telah berpartner dengan kami</h4>
    <!-- Dataset Klien -->
    <div class="client-scroll-wrapper">
      <div class="client-scroll-track">
        <img src="{{ asset('images/klien/klien-img-1.png') }}" alt="BRI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-2.png') }}" alt="BPJS" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-3.png') }}" alt="BACI ACAY" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-4.png') }}" alt="BSI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-5.png') }}" alt="SMKN 10 GARUT" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-6.png') }}" alt="IPI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-7.png') }}" alt="BJB" class="client-logo">
        
        <!-- Duplikat untuk loop seamless -->
        <img src="{{ asset('images/klien/klien-img-1.png') }}" alt="BRI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-2.png') }}" alt="BPJS" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-3.png') }}" alt="BACI ACAY" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-4.png') }}" alt="BSI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-5.png') }}" alt="SMKN 10 GARUT" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-6.png') }}" alt="IPI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-7.png') }}" alt="BJB" class="client-logo">
      </div>
    </div>
  </div>
</section>

<!-- Dataset Portofolio -->
  <div class="container-fluid px-0 pb-5" id="portfolio-gallery">
    <div class="row g-2">
    {{-- Gambar 1 --}}
    <div class="col-12 col-sm-6 col-md-3 position-relative">
      <div class="portfolio-item position-relative with-overlay">
        <img src="{{ asset('images/portofolio/portofolio-img-1.png') }}" alt="Project 1" class="img-fluid shadow-sm portfolio-img">
      </div>
    </div>
    {{-- Gambar Lainnya --}}
    @for ($i = 2; $i <= 12; $i++)
    <div class="col-12 col-sm-6 col-md-3 gallery-hidden">
      <div class="portfolio-item position-relative">
        <img src="{{ asset("images/portofolio/portofolio-img-$i.png") }}" alt="Project {{ $i }}" class="img-fluid shadow-sm portfolio-img">
      </div>
    </div>
    @endfor
  </div>
  {{-- Button Lihat Lainnya ( di mobile) --}}
  <div class="text-center mt-3 d-sm-none">
    <button id="showGalleryBtn" class="btn btn-outline btn-sm">Lihat lainnya</button>
  </div>

{{-- KONSULTASI SECTION --}}
<section class="consultation-section">
  {{-- Summary --}}
  <div class="container content">
    <h4 class="fw-bold">Konsultasikan Kebutuhan Mencetak Anda Sekarang Juga</h4>
    <p class="mt-3 mb-4">
      Dulur Setting menawarkan layanan konsultasi yang dapat membantu anda memilih solusi percetakan terbaik <br>
      untuk kebutuhan anda. Kami siap melayani anda dengan sepenuh hati!
    </p>
    <a href="https://wa.me/62895612811600" class="btn btn btn-secondary btn-md"><i class="bi bi-whatsapp"></i>Konsultasikan via WhatsApp</a>
  </div>
</section>


@endsection

<script>
  window.products = @json($productsForJs);

  document.addEventListener("DOMContentLoaded", function () {
    const gallery = document.getElementById("portfolio-gallery");
    const showBtn = document.getElementById("showGalleryBtn");
    if (showBtn && gallery) {
      showBtn.addEventListener("click", function () {
        gallery.classList.add("show-all");   
      showBtn.remove();                   
      });
      }
    });
 
    const filterContainer = document.querySelector('.filter-buttons');
    const btnLeft = document.querySelector('.scroll-btn.left');
    const btnRight = document.querySelector('.scroll-btn.right');

  function updateArrows() {
    const scrollLeft = filterContainer.scrollLeft;
    const maxScrollLeft = filterContainer.scrollWidth - filterContainer.clientWidth;

    btnLeft.style.display = scrollLeft <= 0 ? 'none' : 'block';
    btnRight.style.display = scrollLeft >= maxScrollLeft - 1 ? 'none' : 'block';
  }

  function scrollFilter(amount) {
    filterContainer.scrollBy({
      left: amount,
      behavior: 'smooth'
    });
  }

  filterContainer.addEventListener('scroll', updateArrows);
  updateArrows();
</script>
<script src="{{ asset('js/pelanggan.js') }}"></script>





