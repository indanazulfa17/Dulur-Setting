<nav class="navbar navbar-expand-lg shadow-sm" style="background: #ffffff;">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100" height="40" class="me-2">
    </a>

    <div class="d-flex align-items-center">
      <form method="POST" action="{{ route('logout') }}" class="mb-0">
        @csrf
        <button class="btn btn-outline-danger rounded-pill px-3 shadow-sm">Logout</button>
      </form>
    </div>
  </div>
</nav>
