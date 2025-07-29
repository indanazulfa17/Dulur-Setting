<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@600&display=swap" rel="stylesheet" />

  <style>
    :root {
      --primary-color: #005FCA;
      --text-dark: #2c3e50;
      --text-dark-1: #60697B
    }

    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      position: relative;
      font-family: 'Inter', sans-serif;
    }

    body {
  background-color: white;
  background-image: url('images/admin/bg-login.svg');
  background-repeat: no-repeat;
  background-position: center bottom;
  background-size: cover;
  position: relative;
}


    body::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, #005FCA, #4686f0);
      z-index: 0;
    }

    .main {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      z-index: 1;
    }

    .login-box {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
      z-index: 2;
    }

    h2 {
      font-family: 'Montserrat', sans-serif;
      text-align: center;
      margin-bottom: 20px;
      font-weight: 600;
      color: var(--text-dark);
    }
    .sub-heading{
        font-family: 'Inter', sans-serif;
      text-align: center;
       margin-bottom: 30px;
      font-weight: 500;
      color: var(--text-dark-1);
    }
    .form-label {
      font-weight: 500;
      color: var(--text-dark-1);
      font-size: 14px;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 15px;
      border: 1px solid #ddd;
    }

    .form-control:focus {
      border-color: #66ADFF;
      box-shadow: none;
    }

    .btn-primary {
      border-radius: 999px;
      font-weight: 500;
      font-size: 16px;
      padding: 10px;
    }

    .btn-primary:hover {
      background-color: #004799;
    }
    .btn-primary:focus {
      background-color: #004799 !important;
      border: none;
    }

    .error-text {
      color: red;
      font-size: 14px;
      text-align: justify;
      margin-bottom: 15px;
    }

    @media (max-width: 576px) {
      .login-box {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="main">
    <div class="login-box">
      <h2>Login</h2>
      <p class="sub-heading"> Silahkan login akun Dulur Setting </p>

      @if ($errors->any())
        <div class="error-text">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-check mt-2">
  <input class="form-check-input" type="checkbox" id="showPassword" onclick="togglePassword()">
  <label class="form-check-label text-muted" for="showPassword">
    Tampilkan Password
  </label>
</div>

        <div class="mt-4">
          <button type="submit" name="loginbtn" class="btn btn-primary w-100">Login</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  function togglePassword() {
    const passwordInput = document.getElementById("password");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
  }
</script>

</body>
</html>
