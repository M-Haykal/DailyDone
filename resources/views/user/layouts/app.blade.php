<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{ asset('img/logo_hayproject.jpeg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css" rel="stylesheet"
        integrity="sha256-V6lu+OdYNKTKTsVFBuQsyIlDiRWiOmtC8VQ8Lzdm2i4=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body class="vh-100 overflow-hidden">
    <!-- Navbar dengan toggle button -->
    <nav class="navbar navbar-expand-lg navbar-dark d-lg-none">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand ms-2 text-black" href="#">Dailydone</a>
        </div>
    </nav>

    <div class="d-flex vh-100">
        <aside id="sidebar"
            class="d-flex flex-column flex-shrink-0 p-3 bg-dark vh-100 overflow-auto offcanvas-lg offcanvas-start"
            style="width: 280px;">
            <div class="d-flex justify-content-between align-items-center">
                <a href="/"
                    class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                    <span class="fs-4 text-white">Dailydone</span>
                </a>
                <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <hr class="text-white">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}"
                        class="nav-link fs-5 {{ request()->routeIs('user.dashboard') ? 'active text-dark ' : 'text-white' }}"
                        aria-current="page">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.project') }}"
                        class="nav-link fs-5 {{ request()->routeIs('user.project') ? 'active text-black' : 'text-white' }}"
                        aria-current="page">
                        <i class="fa-solid fa-folder"></i>
                        Projects
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.archive') }}"
                        class="nav-link fs-5 {{ request()->routeIs('user.archive') ? 'active text-black' : 'text-white' }}"
                        aria-current="page">
                        <i class="fa-solid fa-box-archive"></i>
                        Archives
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.projects.trashed') }}"
                        class="nav-link fs-5 {{ request()->routeIs('user.projects.trashed') ? 'active text-black' : 'text-white' }}"
                        aria-current="page">
                        <i class="fa-solid fa-trash"></i>
                        Trashs
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.notes') }}"
                        class="nav-link fs-5 {{ request()->routeIs('user.notes') ? 'active text-black' : 'text-white' }}"
                        aria-current="page">
                        <i class="fa-solid fa-note-sticky"></i>
                        Notes
                    </a>
                </li>
            </ul>
            <hr class="text-white">
            <div class="dropdown">
                <a href="#"
                    class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle text-white"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->image_profile ? url('storage/images/' . auth()->user()->image_profile) : Avatar::create(auth()->user()->name)->toBase64() }}"
                        alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>{{ auth()->user()->name }}</strong>
                </a>
                <ul class="dropdown-menu text-small shadow">
                    <li><a class="dropdown-item" href="#">Notification</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </aside>

        <!-- Konten utama -->
        <article class="vh-100 overflow-auto flex-grow-1 overflow-x-hidden">
            @yield('content')
        </article>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tiny.cloud/1/qmsq1hga0tygul287yejg9t6gpfa5npa36c0ezchh4zom7x1/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="http://SortableJS.github.io/Sortable/Sortable.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('script')
</body>

</html>
