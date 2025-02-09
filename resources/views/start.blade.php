<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DailyDone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
            text-align: center;
        }

        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            animation: fadeIn 1.5s ease-in-out;
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 10px;
            animation: fadeIn 2s ease-in-out;
        }

        .btn-custom {
            margin-top: 20px;
            padding: 12px 30px;
            font-size: 1.2rem;
            border-radius: 30px;
            background: #ff6f61;
            border: none;
            transition: 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background: #ff3b2e;
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="hero">
        <h1>Selamat Datang di DailyDone!</h1>
        <p>Tempat terbaik untuk merencanakan ide anda.</p>
        @auth
            @if (auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="btn btn-custom">Mulai Sekarang</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn btn-custom">Mulai Sekarang</a>
            @endif
        @else
            @if (Route::has('register'))
                <a href="{{ route('login') }}" class="btn btn-custom">Masuk Sekarang</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-custom">Daftar Sekarang</a>
            @endif
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
