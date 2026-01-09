<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{ asset('img/logo_hayproject.jpeg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="bg-base-100">
    <!-- Navbar dengan toggle button -->
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <!-- Navbar -->
            <nav class="navbar w-full bg-base-200">
                <div class="flex-1"></div>
                <div class="flex gap-2">
                    <label class="swap swap-rotate btn btn-ghost btn-circle">
                        <input id="theme-toggle" type="checkbox" class="theme-controller" value="dark" />
                        <i class="fa-solid fa-moon swap-on"></i>
                        <i class="fa-solid fa-sun swap-off"></i>
                    </label>

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img alt="Tailwind CSS Navbar component"
                                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                            </div>
                        </div>
                        <ul tabindex="-1"
                            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                            <li>
                                <a class="justify-between text-primary">
                                    Profile
                                    <span class="badge">New</span>
                                </a>
                            </li>
                            <li><a>Dashboard</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content here -->
            <div class="p-4">@yield('content')</div>
        </div>

        <div class="drawer-side is-drawer-close:overflow-visible">
            <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="flex min-h-full flex-col bg-base-200 is-drawer-close:w-14 is-drawer-open:w-64">
                <!-- Sidebar Header -->
                <div class="navbar bg-base-200 min-h-0 px-2">
                    <a href="#" class="text-xl font-bold is-drawer-close:hidden">DailyDone</a>
                    <div class="flex-1"></div>
                    <label for="my-drawer-4" aria-label="close sidebar" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linejoin="round"
                            stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"
                            class="my-1.5 inline-block size-4">
                            <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                            </path>
                            <path d="M9 4v16"></path>
                            <path d="M14 10l2 2l-2 2"></path>
                        </svg>
                    </label>
                </div>
                <!-- Sidebar Menu -->
                <ul class="menu w-full grow px-2 pb-4 py-2">
                    <!-- List item -->
                    <li>
                        <a href="#" class="is-drawer-close:tooltip is-drawer-close:tooltip-right"
                            data-tip="Homepage">
                            <!-- Home icon -->
                            <i class="fa-solid fa-house"></i>
                            <span class="is-drawer-close:hidden">Dashboard</span>
                        </a>
                    </li>

                    <!-- List item -->
                    <li>
                        <a href="#" class="is-drawer-close:tooltip is-drawer-close:tooltip-right"
                            data-tip="Projects">
                            <!-- Settings icon -->
                            <i class="fa-solid fa-folder"></i>
                            <span class="is-drawer-close:hidden">Projects</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @Vite('resources/js/app.js')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tiny.cloud/1/qmsq1hga0tygul287yejg9t6gpfa5npa36c0ezchh4zom7x1/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="http://SortableJS.github.io/Sortable/Sortable.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('script')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.getElementById('sign-out').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out of your account.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, sign out',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('logout') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(response => {
                        if (response.ok) {
                            window.location.href = '/';
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to log out. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            }
                        });
                    });
                }
            });
        });
    </script>
</body>

</html>
