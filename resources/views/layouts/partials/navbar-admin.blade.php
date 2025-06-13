<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100px" height="40px"></a>
        <div class="d-flex">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>
