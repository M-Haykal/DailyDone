<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/jpg" href="{{ asset('img/logo_hayproject.jpeg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Font Awesome Icons -->
    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/material-css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet" />

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="g-sidenav-show  bg-gray-100">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2 d-lg-block d-xl-block"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0 " href="{{ route('user.dashboard') }}" target="_blank">
                <img src="{{ asset('img/logo_hayproject.jpeg') }}" class="navbar-brand-img rounded-circle"
                    width="30" height="30" alt="main_logo">
                <span class="ms-1 text-sm text-dark">Daily Done</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item my-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="ps-4 text-uppercase mb-0 text-xs text-dark font-weight-bolder opacity-5">
                            Menu
                        </h6>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link  text-dark {{ request()->routeIs('user.dashboard') ? 'bg-gradient-dark text-white' : '' }}"
                        href="{{ route('user.dashboard') }}">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('user.project') ? 'bg-gradient-dark text-white' : '' }}"
                        href="{{ route('user.project') }}">
                        <i class="material-symbols-rounded opacity-5">task_alt</i>
                        <span class="nav-link-text ms-1">Projects</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('user.archive') ? 'bg-gradient-dark text-white' : '' }}"
                        href="{{ route('user.archive') }}">
                        <i class="material-symbols-rounded opacity-5">archive</i>
                        <span class="nav-link-text ms-1">Archive</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('user.deadline') ? 'bg-gradient-dark text-white' : '' }}"
                        href="{{ route('user.deadline') }}">
                        <i class="material-symbols-rounded opacity-5">date_range</i>
                        <span class="nav-link-text ms-1">Deadline</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('user.notes') ? 'bg-gradient-dark text-white' : '' }}"
                        href="{{ route('user.notes') }}">
                        <i class="material-symbols-rounded opacity-5">description</i>
                        <span class="nav-link-text ms-1">Notes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('user.projects.trashed') ? 'bg-gradient-dark text-white' : '' }}"
                        href="{{ route('user.projects.trashed') }}">
                        <i class="material-symbols-rounded opacity-5">delete</i>
                        <span class="nav-link-text ms-1">Trash</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
            <div class="mx-3">
                <button class="btn btn-outline-danger w-100 align-items-center" id="logout-btn"><i
                        class="material-symbols-rounded py-2">logout</i>Logout</button>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="post" id="logout-form">
            @csrf
        </form>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg my-2">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl bg-white" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                            {{ request()->routeIs('user.dashboard') ? 'Dashboard' : (request()->routeIs('user.project') ? 'Projects' : (request()->routeIs('user.archive') ? 'Archive' : (request()->routeIs('user.deadline') ? 'Deadline' : (request()->routeIs('user.notes') ? 'Notes' : (request()->routeIs('user.projects.trashed') ? 'Trash' : (request()->routeIs('user.profile') ? 'Profile' : (request()->routeIs('user.profile.edit') ? 'Edit Profile' : (request()->routeIs('projects.show') ? 'Detail Project' : (request()->routeIs('user.detailList') ? 'Detail List' : (request()->routeIs('user.tasklist.viewEdit') ? 'Edit List' : '')))))))))) }}
                        </li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav d-flex align-items-center justify-content-end">
                        <li class="nav-item dropdown mx-4 mb-0 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0 position-relative"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="material-symbols-rounded">notifications</i>
                                @php
                                    $projectsNotification = $projects->filter(function ($project) {
                                        return $project->user_id == auth()->id() ||
                                            $project->sharedUsers->contains(auth()->id());
                                    });
                                @endphp
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $projectsNotification->count() }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
                                @forelse ($projectsNotification as $project)
                                    <li class="mb-2">
                                        <a class="dropdown-item border-radius-md"
                                            href="{{ route('projects.show', $project->id) }}">
                                            <div class="d-flex py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-normal mb-1">
                                                        <span class="font-weight-bold">{{ $project->name }}</span>
                                                        {{ \Carbon\Carbon::parse($project->end_date)->isPast() ? 'telah berakhir' : 'segera berakhir' }}
                                                    </h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        <i class="fa fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($project->end_date)->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-center text-muted p-2">Tidak ada notifikasi</li>
                                @endforelse
                            </ul>
                        </li>

                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('user.profile') }}" class="nav-link text-body font-weight-bold px-0">
                                <span>{{ auth()->user()->name }}</span>
                                <img src="{{ auth()->user()->image_profile ? url('storage/images/' . auth()->user()->image_profile) : Avatar::create(auth()->user()->name)->toBase64() }}"
                                    alt="" srcset="" class="avatar avatar-sm rounded-circle me-2">
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav"
                                data-bs-target="#sidenav-main" aria-controls="sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-2">
            @yield('content')
            <footer class="footer py-4  ">
                <div class="container-fluid">
                    <div class="row justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart"></i> by
                                <a href="https://m-haykal.github.io/hayporto" class="font-weight-bold"
                                    target="_blank">Creative Tim</a>
                                for a better web.
                            </div>
                        </div>
                        <div class="col-lg-6 text-lg-end text-center text-muted text-sm">
                            <p>Developer by <a href="https://m-haykal.github.io/hayporto">HayProject</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    @include('user.modal.create-project')
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init();
        // document.getElementById('iconNavbarSidenav').addEventListener('click', function() {
        //     var sidenav = document.getElementById('sidenav-main');
        //     sidenav.classList.toggle('d-none');
        // });

        function confirmDelete(event, projectId) {
            event.preventDefault();

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Proyek yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + projectId).submit();
                }
            });
        }
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan logout!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        });

        document.getElementById('logout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            axios.post(this.action, $(this).serialize())
                .then(response => {
                    window.location.href = response.data.redirect;
                })
                .catch(error => {
                    console.log(error);
                });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
            const sidenavMain = document.getElementById('sidenav-main');

            if (iconNavbarSidenav && sidenavMain) {
                iconNavbarSidenav.addEventListener('click', function() {
                    // Toggle class untuk menampilkan/menyembunyikan sidebar
                    if (sidenavMain.classList.contains('d-none')) {
                        sidenavMain.classList.remove('d-none');
                        sidenavMain.classList.add('d-block');
                        sidenavMain.style.width = '250px';
                    } else {
                        sidenavMain.classList.add('d-none');
                        sidenavMain.classList.remove('d-block');
                        sidenavMain.style.width = '0';
                    }
                });
            }

            // Handle resize event untuk responsive behavior
            window.addEventListener('resize', function() {
                if (window.innerWidth < 1200) { // Sesuaikan dengan breakpoint yang diinginkan
                    sidenavMain.classList.add('d-none');
                    sidenavMain.classList.remove('d-block');
                } else {
                    sidenavMain.classList.remove('d-none');
                    sidenavMain.classList.add('d-block');
                }
            });

            // Inisialisasi awal berdasarkan ukuran layar
            if (window.innerWidth < 1200) {
                sidenavMain.classList.add('d-none');
                sidenavMain.classList.remove('d-block');
            }
        });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('js/material-dashboard.min.js?v=3.2.0') }}"></script>
    <script src="http://SortableJS.github.io/Sortable/Sortable.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    @yield('script')
</body>

</html>
