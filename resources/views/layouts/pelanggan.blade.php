<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Dulur Setting | Percetakan Lengkap Garut' }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    

    <!-- AOS (Animate On Scroll) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
</head>
<body>
    <!-- ✅ Loading Spinner -->
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div id="page" style="display: none;">
        {{-- ✅ Navbar --}}
        @include('layouts.partials.navbar-pelanggan')

        {{-- ✅ Konten halaman --}}
        <main>
            @yield('content')
            {{-- Whatsapp Sticky --}}
            <a href="https://wa.me/62895612811600" class="whatsapp-float" target="_blank" title="Hubungi kami via WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            {{-- Help Modal --}}
            <x-help-modal />
        </main>

        {{-- ✅ Footer --}}
        @include('layouts.partials.footer-pelanggan')
    </div>

    <!-- scripts -->
    @yield('scripts')

    {{-- JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c7f882870d.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/pelanggan.js') }}"></script>
    <!-- AOS Script -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
    window.addEventListener("load", function () {
        document.getElementById("loader").style.display = "none";
        document.getElementById("page").style.display = "block";
    });
</script>

</body>
</html>
