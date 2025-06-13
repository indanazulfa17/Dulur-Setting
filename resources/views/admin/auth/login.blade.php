
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <title>Login</title>
    <style>
        .main {
            height: 100vh;
        }

        .login-box {
            width: 100%;
            max-width: 500px;
            padding: 30px 50px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }

        .login-box h2 {
            margin-bottom: 25px;
            text-align: center;
            color: var(--text-dark-2);
        }

        .form-label{
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark-2);
        }

        .form-control{
            border-radius: 12px;
            padding: 8px 12px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="main d-flex flex-column justify-content-center align-items-center">
    <div class="login-box">
        <h2>Login</h2>

         @if ($errors->any())
        <div style="color:red;">
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
                <button type="submit" name="loginbtn"class="btn btn-primary btn-md w-100">Login</button>
            </div>
        </form>
    </div>
</div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</html>

