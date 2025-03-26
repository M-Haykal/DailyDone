<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{ asset('img/logo_hayproject.jpeg') }}">
    <title>DailyDone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/animsition.min.css') }}">
    <style>
        body {
            background-image: url('{{ asset('img/office-dark.jpg') }}');
            color: white;
            text-align: center;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
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
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .btn-custom {
            margin-top: 20px;
            padding: 12px 30px;
            font-size: 1.2rem;
            border-radius: 30px;
            background: #e91e63;
            border: none;
            transition: 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background: rgb(236.3, 63.75, 122.4);
            transform: scale(1.1);
        }
    </style>
</head>

<body data-aos-easing="ease" data-aos-duration="1000" data-aos-delay="0">

    <div class="hero">
        <div class="text" data-aos="fade-right">
            <h1>Welcome to DailyDone!</h1>
            <p>The best place to plan your ideas.</p>
        </div>
        <div class="action animsition-overlay" data-animsition-overlay="true">
            @auth
                <a href="{{ route('user.dashboard') }}" class="btn btn-custom animsition-link"
                    data-animsition-out-class="overlay-slide-out-top">Start Now</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom animsition-link"
                    data-animsition-out-class="overlay-slide-out-top" data-animsition-out-duration="200">Log In
                    Now</a>
            @endauth
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="{{ asset('js/animsition.min.js') }}"></script>
    <script>
        AOS.init();

        $(document).ready(function() {
            $(".animsition-overlay").animsition({
                inClass: 'overlay-slide-in-top',
                outClass: 'overlay-slide-out-top',
                inDuration: 1500,
                outDuration: 800,
                linkElement: '.animsition-link',
                // e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
                loading: true,
                loadingParentElement: 'body', //animsition wrapper element
                loadingClass: 'animsition-loading',
                loadingInner: '', // e.g '<img src="loading.svg" />'
                timeout: false,
                timeoutCountdown: 5000,
                onLoadEvent: true,
                browser: ['animation-duration', '-webkit-animation-duration'],
                // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
                // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
                overlay: true,
                overlayClass: 'animsition-overlay-slide',
                overlayParentElement: 'body',
                transition: function(url) {
                    window.location.href = url;
                }
            });
        });
    </script>
</body>

</html>
