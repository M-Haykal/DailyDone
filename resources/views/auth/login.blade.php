<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo_hayproject.jpeg') }}">
    <title>DailyDone | Login</title>
    <!-- Fonts and Icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    @vite('resources/css/app.css')
    <style>
        .bg-image {
            background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-200">
    <main class="main-content min-vh-100 d-flex align-items-center justify-content-center bg-image">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg border-radius-lg">
                        <div class="card-header bg-transparent text-center py-4">
                            <h4 class="text-dark font-weight-bolder mb-0">Login to DailyDone</h4>
                        </div>
                        <div class="card-body p-5">
                            <form role="form" method="POST" action="{{ route('login') }}" aria-label="Login form">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        aria-describedby="emailHelp" />
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                        aria-describedby="passwordHelp">
                                    <small id="passwordHelp" class="form-text text-muted">Enter your password</small>
                                </div>
                                <div class="form-check form-switch d-flex align-items-center mb-4">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember"
                                        checked>
                                    <label class="form-check-label ms-2" for="rememberMe">Remember me</label>
                                </div>
                                <div class="text-center mb-4">
                                    <button type="submit" class="btn btn-success w-100">Login</button>
                                </div>
                                <div class="text-center mb-4">
                                    <small class="d-block mb-2">or</small>
                                    <a href="{{ route('auth.google') }}" class="btn btn-outline-primary w-100">
                                        <i class="fab fa-google me-2"></i>Login with Google
                                    </a>
                                </div>
                                <p class="text-center text-sm mt-4 mb-0">
                                    Don't have an account?
                                    <a href="{{ route('register') }}"
                                        class="text-primary font-weight-bold text-decoration-none">Register</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @vite('resources/js/app.js')
</body>

</html>
