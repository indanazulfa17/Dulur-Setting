<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Montserrat & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --text-dark: #2c3e50;
            --bg-light: #f4f6f8;
        }

        * {
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            margin: 0;
           background: linear-gradient(135deg, #005FCA, #4686f0, #005FCA);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

        h2, label {
            font-family: 'Montserrat', sans-serif;
        }

        .main {
            height: 100vh;
        }

        .login-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            transition: 0.3s ease;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-label {
            font-weight: 500;
            color: #343F52;
            font-size: 14px;
            font-family: 'Inter';
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 15px;
            border: 1px solid #ddd;
            transition: 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
        }

        .btn-primary {
            border-radius: 999px;
            font-weight: 500;
            font-size: 16px;
            padding: 10px;
            transition: 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .error-text {
            color: red;
            font-size: 14px;
            text-align: center;
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

<div class="main d-flex justify-content-center align-items-center">
    <div class="login-box">
        <h2>Login</h2>

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
            <div class="mt-4">
                <button type="submit" name="loginbtn" class="btn btn-primary w-100">Login</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
