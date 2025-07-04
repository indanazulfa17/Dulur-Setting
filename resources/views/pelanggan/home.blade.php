@extends('layouts.pelanggan')

@section('title', 'home')

@section('content')


<!-- HERO SECTION -->
<section class="hero position-relative">
  <div class="container hero-content">
    <!-- Summary Hero -->
    <div class="row align-items-center">
      <div class="col-lg-10 hero-text fade-up">
        <h5>Selamat datang di Dulur Setting</h5>
        <div class="display">Solusi Percetakan Terpercaya</div>
        <br><p>Wujudkan ide Anda jadi cetakan berkualitas mudah, cepat, dan tanpa ribet dengan layanan Dulur Setting, dan buat promosi usaha anda jadi mudah.</p>
        <a href="#layanan" class="btn btn-secondary btn-md"> Lihat Layanan <i class="fa-solid fa-circle-chevron-down"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- LAYANAN SECTION -->
<section id="layanan" class="layanan py-10">
  <div class="container text-center">
    <!-- Summary Layanan -->
    <h5 class="mb-3">Layanan Kami</h5>
    <h4 class="mb-4">Layanan Percetakan Berkualitas untuk Berbagai Kebutuhan</h4>
    <p class="desc">Temukan layanan cetak yang kamu butuhkan di sini, dengan beragam pilihan.</p>
    <!-- Search Bar -->
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
    <!-- Dataset Layanan -->
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <!-- Filter Buttons -->
        <div class="filter-buttons mb-4">
          <button class="btn btn-outline-custom active me-2" onclick="filterCategory('all', this)">Semua</button>
          <button class="btn btn-outline-custom me-2" onclick="filterCategory('percetakan', this)">Percetakan</button>
          <button class="btn btn-outline-custom me-2" onclick="filterCategory('digital-printing', this)">Digital Printing</button>
          <button class="btn btn-outline-custom me-2" onclick="filterCategory('advertising', this)">Advertising</button>
        </div>
        <!-- Product Grid -->
        <div id="productGrid" class="row "></div>
        <!-- Load More Button -->
        <div class="d-flex justify-content-center mt-4">
          <button class="btn btn-tertiary" onclick="loadMore()">Lihat Lainnya</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- LAYANAN DESAIN GRAFIS -->
<section class="container layanan-desain">
  <div class="container-content" data-animate>
    <!-- Summary -->
    <h4 class="mb-4">Butuh bantuan mendesain?</h4>
    <p> Ingin desain sesuai keinginanmu? Bisa! Dulur Setting menyediakan layanan jasa desain grafis, termasuk desain kustom. Konsultasikan kebutuhanmu, dan kami siap bantu mewujudkannya lewat WhatsApp.</p>
    <a href="https://wa.me/62895612811600" class="btn btn-secondary btn-md">
      <i class="bi bi-whatsapp"></i> Konsultasikan via WhatsApp
    </a>
  </div>
</section>

<!-- KENAPA KAMI SECTION -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <!-- Dataset Card Kenapa Kami -->
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

<!-- LANGKAH PEMESANAN SECTION -->
<div class="container langkah-section">
  <div class="row align-items-center">
    <!-- Summary (Gambar) -->
    <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-delay="100" data-aos-offset="200">
      <img src="{{ asset('images/cara-pemesanan/image.png') }}" alt="Cara Pemesanan" class="img-fluid">
    </div>
    <!-- Dataset Langkah -->
    <!-- Heading -->
    <div class="col-md-6" data-aos="fade-left" data-aos-delay="200" data-aos-offset="200">
       <h5 class="mb-3">Cara Pemesanan</h5>
      <h4 class="mb-4">Langkah Mudah Cetak Online</h4>
      <p class="desc">Tentukan produk yang ingin Anda cetak sebelum mengunggah file</p>
    <!-- Langkah-Langkah -->
    <div class="step-item d-flex" data-aos="fade-up" data-aos-delay="300">
  <div class="icon-wrapper">
    <img src="{{ asset('images/cara-pemesanan/icon-1.png') }}" alt="Pilih Produk">
  </div>
  <div class="step-text ms-3">
    <p class="step-title fw-bold mb-1">1. Pilih Produk</p>
    <p class="step-description mb-0">Temukan produk cetak sesuai kebutuhan Anda, dari poster, brosur, kartu nama, hingga stiker.</p>
  </div>
</div>
<div class="step-item d-flex" data-aos="fade-up" data-aos-delay="300">
  <div class="icon-wrapper">
    <img src="{{ asset('images/cara-pemesanan/icon-2.png') }}" alt="Custom Desain">
  </div>
  <div class="step-text ms-3">
    <p class="step-title fw-bold mb-1">2. Custom Design</p>
    <p class="step-description mb-0">Isi detail pesanan : ukuran, bahan, jumlah, dan unggah file desain yang ingin dicetak</p>
  </div>
</div>
<div class="step-item d-flex" data-aos="fade-up" data-aos-delay="300">
  <div class="icon-wrapper">
    <img src="{{ asset('images/cara-pemesanan/icon-3.png') }}" alt="Custom Desain">
  </div>
  <div class="step-text ms-3">
    <p class="step-title fw-bold mb-1">3. Cek Harga</p>
    <p class="step-description mb-0">Lihat estimasi harga dari pesanan kamu sebelum kamu melanjutkan ke tahap pemesanan</p>
  </div>
</div>
<div class="step-item d-flex" data-aos="fade-up" data-aos-delay="300">
  <div class="icon-wrapper">
    <img src="{{ asset('images/cara-pemesanan/icon-4.png') }}" alt="Custom Desain">
  </div>
  <div class="step-text ms-3">
    <p class="step-title fw-bold mb-1">4. Order</p>
    <p class="step-description mb-0">Klik "Pesan Sekarang" kamu akan diarahkan ke WhatsApp untuk konfirmasi dan proses pembayaran</p>
  </div>
</div>
    </div>
  </div>
</div>

<!-- Klien Section -->
<section class="klien-section">
  <div class="container text-center">
    <!-- Summary Klien -->
    <h5 class="mb-3">Klien Kami</h5>
    <h4 class="mb-4">Klien yang telah berpartner dengan kami</h4>
    <!-- Dataset Klien -->
    <div class="client-scroll-wrapper">
      <div class="client-scroll-track">
        <img src="{{ asset('images/klien/klien-img-1.png') }}" alt="BRI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-2.png') }}" alt="BPJS" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-3.png') }}" alt="BACI ACAY" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-4.png') }}" alt="BSI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-5.png') }}" alt="SMKN 10 GARUT" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-6.png') }}" alt="IPI" class="client-logo">
        
        <!-- Duplikat untuk loop seamless -->
        <img src="{{ asset('images/klien/klien-img-1.png') }}" alt="BRI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-2.png') }}" alt="BPJS" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-3.png') }}" alt="BACI ACAY" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-4.png') }}" alt="BSI" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-5.png') }}" alt="SMKN 10 GARUT" class="client-logo">
        <img src="{{ asset('images/klien/klien-img-6.png') }}" alt="IPI" class="client-logo">
      </div>
    </div>
  </div>
</section>

<!-- Portofolio Section -->
<!--<section class="portfolio-section bg-white">
  <!-- Summary Portofolio 
  <div class="container text-center">
  <h5 class="mb-3">Portofolio</h5>
  <h4 class="mb-4">Project yang telah dikerjakan Dulur Setting</h4>
  </div> -->
  <!-- Dataset Portofolio -->
  <div class="container-fluid px-0 pb-5">
    <div class="row g-0">
      <div class="col-3">
        <div class="portfolio-item position-relative">
          <img src="{{ asset('images/portofolio/portofolio-img-1.png') }}" alt="Project 1" class="img-fluid shadow-sm portfolio-img">
          <div class="overlay"></div>
        </div>
      </div>
      <div class="col-3">
        <div class="portfolio-item position-relative">
          <img src="{{ asset('images/portofolio/portofolio-img-2.png') }}" alt="Project 2" class="img-fluid shadow-sm portfolio-img">
          <div class="overlay"></div>
        </div>
      </div>
      <div class="col-3">
        <div class="portfolio-item position-relative">
          <img src="{{ asset('images/portofolio/portofolio-img-3.png') }}" alt="Project 3" class="img-fluid shadow-sm portfolio-img">
          <div class="overlay"></div>
        </div>
      </div>
      <div class="col-3">
        <div class="portfolio-item position-relative">
          <img src="{{ asset('images/portofolio/portofolio-img-4.png') }}" alt="Project 4" class="img-fluid shadow-sm portfolio-img">
          <div class="overlay"></div>
        </div>
      </div>
      <div class="col-3">
        <div class="portfolio-item position-relative">
          <img src="{{ asset('images/portofolio/portofolio-img-5.png') }}" alt="Project 5" class="img-fluid shadow-sm portfolio-img">
          <div class="overlay"></div>
        </div>
      </div>
      <div class="col-3">
        <div class="portfolio-item position-relative">
          <img src="{{ asset('images/portofolio/portofolio-img-6.png') }}" alt="Project 6" class="img-fluid shadow-sm portfolio-img">
          <div class="overlay"></div>
        </div>
      </div>
      <div class="col-3">
        <div class="portfolio-item position-relative">
          <img src="{{ asset('images/portofolio/portofolio-img-1.png') }}" alt="Project 6" class="img-fluid shadow-sm portfolio-img">
          <div class="overlay"></div>
        </div>
      </div>
      <div class="col-3">
        <div class="portfolio-item position-relative">
          <img src="{{ asset('images/portofolio/portofolio-img-2.png') }}" alt="Project 6" class="img-fluid shadow-sm portfolio-img">
          <div class="overlay"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- KONSULTASI SECTION -->
<section class="consultation-section">
  <!-- Summary Konsultasi -->
  <div class="container content">
    <h4 class="fw-bold">Konsultasikan Kebutuhan Mencetak Anda Sekarang Juga</h4>
    <p class="mt-3 mb-4">
      Dulur Setting menawarkan layanan konsultasi yang dapat membantu anda memilih solusi percetakan terbaik <br>
      untuk kebutuhan anda. Kami siap melayani anda dengan sepenuh hati!
    </p>
    <a href="https://wa.me/62895612811600" class="btn btn btn-secondary btn-md"><i class="bi bi-whatsapp"></i>Konsultasikan via WhatsApp</a>
  </div>
</section>

<!-- Tombol WhatsApp Sticky dengan Font Awesome -->
<a href="https://wa.me/62895612811600" class="whatsapp-float" target="_blank" title="Hubungi kami via WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>


@endsection

<script>
    window.products = @json($productsForJs);
</script>
    <script src="{{ asset('js/pelanggan.js') }}"></script>





