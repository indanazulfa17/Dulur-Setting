@extends('layouts.pelanggan')

@section('title', 'tentang')

@section('content')

{{-- Header --}}
<header>
  <h1>Tentang Kami</h1>
  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="breadcrumb-products d-flex justify-content-center mb-2">
    <ol class="breadcrumb bg-transparent p-2">
      <li class="breadcrumb-item">
        <a href="{{ route('pelanggan.beranda') }}"><i class="fas fa-home me-1"></i> Beranda</a>
      </li>
      <li class="breadcrumb-item active text-white" aria-current="page"> Tentang Kami</li>
    </ol>
  </nav>
</header>

{{-- TETANG KAMI SECTION --}}
<div class="container-custom">
  {{-- Tentang --}}
  <section class="about py-5">
    <img src="{{ asset('images/tentang-kami/img-about.jpg') }}" alt="Foto Dulur Setting" data-aos="fade-right" data-aos-delay="100" data-aos-offset="200">
    <div class="about-text" data-aos="fade-left" data-aos-delay="200" data-aos-offset="200">
      <h5 class="heading">Tentang Dulur Setting</h5>
      <h4 class="sub-heading">Mewujudkan Ide Menjadi Karya Cetak</h4>
      <p class="desc">Ditengah prestasi yang telah dicapai,kami tidak akan berhenti dan berpuas diri dalam memberikan produk dan layanan terbaik kepada pelanggan. Dengan terus berinovasi dalam melayani, kami berupaya untuk selalu selangkah lebih maju dalam mengantisipasi kebutuhan pelanggan kami. Oleh karena itu Dulur Setting hadir untuk memenuhi kebutuhan, keperluan dan keinginan khususnya dalam bidang Desain Grafis, Percetakan & Advertising.
        <br><br>Dulur Setting berniat untuk menjadi “The Greats Design Graphic, Printing & Advertising” Untuk mencapai tujuan tersebut, kami senantiasa bekerja keras untuk menjadi terpercaya yang mampu memberikan manfaat nyata bagi pelanggan kami. Tujuan utama adalah untuk mencapai pertumbuhan dan profitabilitas usaha percetakan yang konsisten. Untuk itu kami berupaya mewujudkannya dengan meningkatkan pelayanan, Teknologi dan Kemitraan. Point plus atau nilai tambah yang kami miliki adalah terbangun dengan database yang terintegrasi, dalam artian bahwa proses data yang berada di Dulur Setting dijalankan oleh sistem komputerisasi dan jaringan dalam satu server. </br></br></p>
    </div>
  </section>
  {{-- Visi Misi --}}
  <section class="vision-mission-wrapper">
    <div class="vision-mission" data-aos="fade-up">
      <div class="card card-visi">
        <h5 class="mb-visi">Visi Dulur Setting</h5>
        <p class="desc">Menjadi percetakan terpercaya yang unggul dalam kualitas, inovatif dalam pelayanan, dan memberikan kontribusi positif bagi masyarakat serta lingkungan. Membangun sebuah istana keberkahan dari Allah SWT melalui setiap karya yang kami hasilkan.</p>
      </div>
      <div class="card card-misi" data-aos="fade-up">
        <h5 class="mb-misi">Misi Dulur Setting</h5>
        <ul>
          <li>Kami hadir untuk memberikan pelayanan terbaik, hasil cetakan yang berkualitas serta tepat waktu dalam mewujudkan keinginan konsumen.</li>
          <li>Kami membentuk team work yang solid, yang disiplin tinggi dan memberikan kepercayaan yang diberikan.</li>
          <li>Kami berkarya untuk tumbuh bersama dan memberi manfaat yang seimbang kepada pemilik perusahaan, manajemen dan karyawan serta lingkungan sekitarnya.</li>
          <li>Kami adalah pengemban amanah untuk bisa memberikan keberlimpahan dan kebarokahan rejeki untuk memperoleh ridho Alloh SWT di akhirat kelak.</li>
        </ul>
      </div>
    </div>
  </section> 
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

