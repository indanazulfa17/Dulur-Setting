{{-- FOOTER SECTION --}}
<footer class="footer">
  <div class="footer-container">
    {{-- Info --}}
    <div class="footer-top">
      {{-- Logo / Brand --}}
      <div class="footer-brand">
        <img src="{{ asset('images/logo-white.png') }}" alt="Dulur Setting Logo" class="logo" style="padding-bottom: 15px;">
        <p>Layanan percetakan kebutuhan usaha Anda, mulai dari kemasan, promosi, hingga cetakan bisnis harian.</p>
      </div>
      {{-- Info Produk --}}
      <div class="footer-contact-info">
        <h5 class="mb-3">Kontak Kami</h5>
        {{-- Alamat --}}
        <div class="info-item">
          <i class="fas fa-map-marker-alt"></i>
          <p>Jl. Pasundan No. 17 Kel., Kota Kulon Kec. Garut Kota, Kabupaten Garut Kode Pos 44112</p>
        </div>
        {{-- No Telepon --}}
        <div class="info-item">
          <i class="fas fa-phone-alt"></i>
          <p><a href="tel:+6285222259229">+62 895-6128-11600</a></p>
        </div>
        {{-- Email --}}
        <div class="info-item">
          <i class="fas fa-envelope"></i>
          <p><a href="mailto:dulursetting@gmail.com">dulursetting@gmail.com</a></p>
        </div>
      </div>
      {{-- Jam Kerja --}}
      <div class="footer-working-hours">
        <h5 class="mb-3">Jam Operasional</h5>
        <p>Senin – Sabtu: 08.00 – 18.00</p>
        <p>Minggu: Kondisional</p>
      </div>
    </div>

    {{-- Navigasi Produk --}}
    <div class="footer-links">
      @foreach ($groupedProducts as $category => $products)
        <div class="footer-column">
          <h5 class="mb-3">{{ $category }}</h5>
            <ul>
              @foreach ($products->take(3) as $product)
                <li><a href="{{ route('pelanggan.products.show', $product->id) }}">{{ $product->name }}</a></li>
              @endforeach
            </ul>
        </div>
      @endforeach
    </div>

    {{-- Follow Us --}}
    <div class="footer-follow">
      <h5 class="mb-3">Ikuti Kami</h5>
      <a href="https://instagram.com/dulursetting" target="_blank" class="follow-icon"><i class="fab fa-instagram"></i>dulursetting</a>
    </div>
      
    {{-- Copyright --}}
    <div class="footer-bottom">
      <p>&copy; 2024 Dulur Setting. All Rights Reserved.</p>
    </div>
  </div>
</footer>
