<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Dashboard Admin</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- Bootstrap CSS & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <!-- ✅ Loading Spinner -->
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div id="page" style="display: none;">
    @include('layouts.partials.navbar-admin')
   
     <div class="container-fluid bg-light">
  
  <main id="mainContent" role="main">
    @yield('content')
  </main>

  </div>
    </div>

    {{-- Bootstrap JS Bundle (cukup satu versi) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Toast Pop-up Success --}}
    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
            <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0 shadow"
                role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const toastEl = document.getElementById('toastSuccess');
                if (toastEl) {
                    const toast = new bootstrap.Toast(toastEl, {
                        delay: 4000
                    });
                    toast.show();
                }
            });
        </script>
    @endif

    {{-- Fungsi Global: Modal Delete --}}
    <script>
        function showDeleteModal(actionUrl) {
            const deleteForm = document.getElementById('deleteForm');
            if (!deleteForm) {
                console.error("Form tidak ditemukan");
                return;
            }

            deleteForm.setAttribute('action', actionUrl);

            const modalElement = document.getElementById('confirmDeleteModal');
            if (!modalElement) {
                console.error("Modal tidak ditemukan");
                return;
            }

            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
        function showLogoutModal() {
    const modalElement = document.getElementById('confirmLogoutModal');
    if (!modalElement) {
        console.error("Modal confirmLogoutModal tidak ditemukan");
        return;
    }

    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

    </script>
    <script>
    window.addEventListener("load", function () {
        document.getElementById("loader").style.display = "none";
        document.getElementById("page").style.display = "block";
    });
</script>

    {{-- Include Modal Logout --}}
    @include('components.logout-modal')
    
    {{-- Slot untuk Script Halaman --}}
    @stack('scripts')

</body>
</html>
