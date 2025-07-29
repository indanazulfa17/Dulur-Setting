@extends('layouts.pelanggan')

@section('title', 'kontak')

@section('content')

{{-- Header --}}
<header>
  <h1>Kontak</h1>
  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="breadcrumb-products d-flex justify-content-center mb-2">
    <ol class="breadcrumb bg-transparent p-2">
      <li class="breadcrumb-item">
        <a href="{{ route('pelanggan.beranda') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      </li>
      <li class="breadcrumb-item active text-white" aria-current="page"> Kontak</li>
    </ol>
  </nav>
</header>

{{-- Kontak Info --}}
<section class="container my-5">
  <div class="row shadow-sm bg-white rounded">
    <div class="kontak col-md-6">
      {{-- Heading --}}
      <h5 class="heading">Kontak</h5>
      <h4 class="sub-heading">Hubungi Kami</h4>
      <p class="desc">Silakan hubungi kontak di bawah untuk info lebih lanjut.</p>
      {{-- No Telepon --}}
      <div class="mb-2 d-flex">
        <img src="{{ asset('images/kontak/icon-telepon.png') }}" alt="Pilih Produk" width="36px" height="36px">
        <div class="ms-3">
          <p class="kontak-item">No Telepon</p>
          <p class="kontak-items"><a href="tel:+62895612811600"> +62 895-6128-11600</a></p>
        </div>
      </div>
      {{-- Email --}}
      <div class="mb-2 d-flex">
        <img src="{{ asset('images/kontak/icon-email.png') }}" alt="Pilih Produk" width="36px" height="36px">
        <div class="ms-3">
          <p class="kontak-item">Email</p>
          <p class="kontak-items"><a href="mailto:dulursetting@gmail.com"> dulursetting@gmail.com</a></p>
        </div>
      </div>
      {{-- Alamat --}}
      <div class="mb-2 d-flex">
        <img src="{{ asset('images/kontak/icon-alamat.png') }}" alt="Pilih Produk" width="36px" height="36px">
        <div class="ms-3">
          <p class="kontak-item">Alamat</p>
          <p class="kontak-items"> Jl. Pasundan No. 17 Kel., Kota Kulon Kec. Garut Kota, Kabupaten Garut Kode Pos 44112 </p>
        </div>
      </div>   
    </div>
    {{-- Google Maps Embed --}}
    <div class="maps col-md-6">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.1668492842914!2d107.90213077357036!3d-7.221801470910388!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68b1fb861e8869%3A0xaae204982bb74cf0!2sdulurSetting!5e0!3m2!1sen!2sid!4v1748066038258!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>

{{-- FAQ --}}
<section class="py-5">
  <div class="container">
    {{-- Summary --}}
    <h5 class="heading text-center ">FAQ</h5>
    <h4 class="sub-heading text-center ">Apa yang Sering Pelanggan Tanyakan?</h4>
    {{-- Dataset 1 --}}
    <div class="accordion shadow-sm rounded" id="faqAccordion">
      <div class="accordion-item border-0 mb-2">
        <h2 class="accordion-header" id="faq1">
          <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
            Apa saja layanan yang disediakan oleh Dulur Setting?
          </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Dulur Setting menyediakan desain grafis, digital printing, percetakan, dan advertising untuk mendukung bisnismu.
          </div>
        </div>
      </div>
      {{-- Dataset 2 --}}
      <div class="accordion-item border-0 mb-2">
        <h2 class="accordion-header" id="faq2">
          <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
            Apakah Dulur Setting juga menyediakan layanan jarak jauh?
          </button>
        </h2>
        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Dulur Setting melayani layanan jarak jauh, dari konsultasi desain hingga pengiriman hasil cetakan online.
          </div>
        </div>
      </div>
      {{-- Dataset 3 --}}
      <div class="accordion-item border-0 mb-2">
        <h2 class="accordion-header" id="faq3">
          <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
            Apakah Dulur Setting juga menerima desain custom?
          </button>
        </h2>
        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Dulur Setting menerima desain custom, bekerja sama dengan klien untuk menciptakan desain yang profesional.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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


