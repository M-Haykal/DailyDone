@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-[1400px] mx-auto w-full">
        <!-- Welcome Back Section -->
        <div class="mb-10">
            <div
                class="flex flex-col md:flex-row md:items-end justify-between gap-6 bg-base-200 p-8 rounded-2xl shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
                    <i class="fa-solid fa-sun text-warning"></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2">Welcome Back,
                        Alex! 👋</h1>
                    <p class="text-lg">Here's what's happening on your desk today.</p>
                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-base-300 p-4 rounded-xl">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-tasks text-primary text-[20px]"></i>
                                <span class="text-xs font-bold uppercase tracking-wider ">Tasks
                                    Due Today</span>
                            </div>
                            <p class="text-2xl font-bold">4 <span
                                    class="text-sm font-medium text-secondary ml-1">Assigned</span></p>
                        </div>
                        <div class="bg-base-300 p-4 rounded-xl">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-bell text-warning text-[20px]"></i>
                                <span class="text-xs font-bold uppercase tracking-wider">Updates</span>
                            </div>
                            <p class="text-2xl font-bold">12 <span
                                    class="text-sm font-medium text-secondary ml-1">Unread</span></p>
                        </div>
                        <div class="bg-base-300 p-4 rounded-xl">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-calendar text-success text-[20px]"></i>
                                <span class="text-xs font-bold uppercase tracking-wider">Next
                                    Meeting</span>
                            </div>
                            <p class="text-2xl font-bold">10:30 <span class="text-sm font-medium text-secondary ml-1">Daily
                                    Sync</span></p>
                        </div>
                    </div>
                </div>
                <!-- Progress Bar Component -->
                <div
                    class="w-full md:w-80 bg-base-300 p-6 rounded-xl">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-bold">Daily Goal Progress</span>
                        <span class="text-sm font-bold text-success">65%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 mb-4">
                        <div class="bg-primary h-2.5 rounded-full" style="width: 65%"></div>
                    </div>
                    <p class="text-xs leading-relaxed">
                        You've completed <span class="font-bold text-secondary">5 out of 8</span>
                        milestones for today. Keep it up!
                    </p>
                </div>
            </div>
        </div>
        <!-- Recently Viewed Grid -->
        <section class="mb-10">
            <div class="flex items-center justify-between mb-6 px-1">
                <h2 class="text-xl font-extrabold tracking-tight">Recently Viewed Boards</h2>
                <a class="text-sm font-bold text-primary hover:underline" href="#">View All</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Board Card 1 -->
                <div
                    class="group bg-base-200 p-5 rounded-xl hover:shadow-md transition-all cursor-pointer">
                    <div
                        class="h-24 w-full rounded-lg mb-4 bg-gradient-to-br from-[#007b80] to-[#00a3a8] p-4 flex items-end">
                        <span class="text-white font-bold text-lg opacity-90">Marketing Q4</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-2 uppercase font-bold tracking-wider">Active 2m ago</p>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <img class="size-6 rounded-full ring-2 ring-white dark:ring-gray-800" data-alt="Team member 1"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBl3mbORPwaKoizvLymnq54CvadOj_vMENnpTvuXaw6_VsRkHGcoyb7Iy6Sh0AXeT2aYMWd6P1AmgwojYbKBLCSg5OUcjxlnmwc7-Mh92_VZ4sPOBfWOGVKRAvxSMnqz2aa5VvGqmNP6IKJGSFzITfEPw9Zdzix3y9dfxmeZTH1obZQG8erBdl4UT_uebZ6CVs55sjw5Srwa7VD7yvCRTQg8ySdtSUYG9M9_xdvKTa65wfVWuByqM4qCcmYYqR2JXNos68GuXEnpKuJ" />
                            <img class="size-6 rounded-full ring-2 ring-white dark:ring-gray-800" data-alt="Team member 2"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuASuyrKBTYHeD4MtfcAzdtO7rJHULjjpImi19usUfdPwPG_ulOiMUWdby5dunjNEfWxoFvDlQZnZyndWzSbtQRZeB1MWQuydfWCc-aIVT7BFw2juQ73_CkTSFXYNESj5tC7EKABajQCGbQQZ4RkmEG2s7u4M-DDz9BJxIDXVrTCgFeqB7-pnk4vXPeziTnn4sS2Uod-dY08s9cgfoqy67VQwPe2HEajAkfRa5LCbjr467ZGenED3pa2OF-4bdRbNyLYNIJ1P0M6BUu7" />
                            <div
                                class="size-6 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[10px] font-bold text-gray-500 ring-2 ring-white dark:ring-gray-800">
                                +3</div>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-300 group-hover:text-primary transition-colors">arrow_forward</span>
                    </div>
                </div>
                <!-- Board Card 2 -->
                <div
                    class="group bg-base-200 p-5 rounded-xl hover:shadow-md transition-all cursor-pointer">
                    <div
                        class="h-24 w-full rounded-lg mb-4 bg-gradient-to-br from-[#3b82f6] to-[#60a5fa] p-4 flex items-end">
                        <span class="text-white font-bold text-lg opacity-90">App Development</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-2 uppercase font-bold tracking-wider">Active 1h ago</p>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <img class="size-6 rounded-full ring-2 ring-white dark:ring-gray-800" data-alt="Team member 3"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCtYCly-SG1iqytWPNm1Qgj2fRnu_QqYsDx-21jYsf6J1NX9Ieu9_FUHwvxtSIyd6BJH5tXJAGqhMrEJvn75Q8ItxcUE4eNvQmLm8BAkTfY8OWaIjfX_c_NN57MYgufHzBMFnOFWiZwWNm2tQk9V2KNHepaSQTE7qi4CaytAKITYG0-j8WTZt2_xWSEMaKuN6videoQbprTfBZdWi2EN0m2WljK0yH-_nT_acrFzom1HVZIuInnQC92suAZT-m_onOKd3PO-XD5t5IR" />
                            <img class="size-6 rounded-full ring-2 ring-white dark:ring-gray-800" data-alt="Team member 4"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuA8ixyy1HGeudgKo6bB8S-1aDpS4tlYHq5XdrgMJ3SmPrxbWlNe9m9a70yl8rxNRFNNRB3huegx95zciRim5g71cwghsieaPPb-Y-ILoOpXLzYyHIXg4ajUFJjK2s_zBLvwelcaOqc_ge81PGYdUvKLfVKCwdk67jptIMT4OYcfY7gwr8yj2uMB_VH3PEZ0Q7XgEfnxxB0SuACzfPsxI_w7zdvDn_0HyciEK6Vd77D_HBhBmDVvI8OL3S6WIgmcvjnxJyNpZsvspfpc" />
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-300 group-hover:text-primary transition-colors">arrow_forward</span>
                    </div>
                </div>
                <!-- Board Card 3 -->
                <div
                    class="group bg-base-200 p-5 rounded-xl hover:shadow-md transition-all cursor-pointer">
                    <div
                        class="h-24 w-full rounded-lg mb-4 bg-gradient-to-br from-[#f59e0b] to-[#fbbf24] p-4 flex items-end">
                        <span class="text-white font-bold text-lg opacity-90">Design System</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-2 uppercase font-bold tracking-wider">Active 4h ago</p>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <img class="size-6 rounded-full ring-2 ring-white dark:ring-gray-800" data-alt="Team member 5"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAqVG4_Bs-KD4nKos3x9E1rUPc6PiRLsiA_O1o7D6ZuhJWhjx-H1pMLU5Id9wyg3BptBAI9WWKZrTCDKf9Vbx6q3Rxwdi88Z_QkeiD6ld-DwCnMN_5M4ETZd8BK_yW9X2QJ8nSJI27g9EG94Kfd_0k_m0W3qwFDEEqBKdbQTyat8owfBfPwU2jw3Sa4iJK4tMq-9Drq63k8q3hjcMWm3JmDVLv-AVb0mr8McFD0huhoX-cTX-1Le3IuxL-bIkl4XLkXWSPvEdpJYaj6" />
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-300 group-hover:text-primary transition-colors">arrow_forward</span>
                    </div>
                </div>
                <!-- Board Card 4 (Add New) -->
                <div
                    class="group bg-dashed bg-base-200 p-5 rounded-xl border-2 border-dashed hover:bg-base-300 transition-all cursor-pointer flex flex-col items-center justify-center text-center">
                    <div
                        class="size-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 mb-2 group-hover:bg-primary group-hover:text-white transition-all">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <span class="text-sm font-bold">Browse All Boards</span>
                </div>
            </div>
        </section>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Up Next Column -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-6 px-1">
                    <h2 class="text-xl font-extrabold tracking-tight">Up Next</h2>
                    <button
                        class="flex items-center gap-1 text-sm font-bold text-gray-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">filter_list</span>
                        Filter
                    </button>
                </div>
                <div class="space-y-4">
                    <!-- Task Item 1 -->
                    <div
                        class="group flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-all shadow-sm">
                        <div
                            class="size-12 rounded-lg bg-red-50 dark:bg-red-900/20 flex flex-col items-center justify-center text-red-600 dark:text-red-400">
                            <span class="text-[10px] font-bold uppercase">Oct</span>
                            <span class="text-lg font-extrabold leading-none">24</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="px-2 py-0.5 rounded bg-primary/10 text-primary text-[10px] font-bold uppercase">Marketing</span>
                                <span class="text-xs text-gray-400 font-medium">Due in 2h</span>
                            </div>
                            <h3 class="font-bold text-[#101818] dark:text-white group-hover:text-primary transition-colors">
                                Finalize Wireframes for Brand Campaign</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-full border-2 border-white dark:border-gray-800">
                                <img class="rounded-full w-full h-full object-cover" data-alt="Assignee avatar"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBMZ0YezYw_zUKwWe-MPCvSvRZstm8lLC_a_yF9MXA7TfmEH7-Zo6df4ceH6HWShwqbrwpNi9RpBLC4OvW-ksW-1VNgVOPMH8wvFkETK93O4UFFBc1sV9Ql3Xo_CgXrrbCDvdFfD87obS-ZjlkQXx2brvJwTd2gohTe6yq5qH_h_r6xDvvwCMhblwQDso4zU53fppc07Ug10roO7AnZYA4j5GY5MyqRyPDNuUqgHg9XaZoqZOzU7XUmcCf7wZZneN5QQ_f9bkN-F_w4" />
                            </div>
                            <button class="size-8 flex items-center justify-center text-gray-400 hover:text-primary">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                        </div>
                    </div>
                    <!-- Task Item 2 -->
                    <div
                        class="group flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-all shadow-sm">
                        <div
                            class="size-12 rounded-lg bg-gray-50 dark:bg-gray-700 flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                            <span class="text-[10px] font-bold uppercase">Oct</span>
                            <span class="text-lg font-extrabold leading-none">25</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-bold uppercase">Mobile
                                    App</span>
                                <span class="text-xs text-gray-400 font-medium">Tomorrow</span>
                            </div>
                            <h3
                                class="font-bold text-[#101818] dark:text-white group-hover:text-primary transition-colors">
                                API Documentation Review</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-full border-2 border-white dark:border-gray-800">
                                <img class="rounded-full w-full h-full object-cover" data-alt="Assignee avatar"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPUd23HEFIr3eytPRR4FRv_JMC17QOhj6PrflPMsidiFRPW-IiYfWUTDpvBqmvTjrrPGZC45SKJKE1N2K4jr1gP25nAfC8eOXgCimQPZiDBcGwpWAiiE9pSWNIZKYffhoI5cp-MxJWtswLtJZv55C0_yttKReS6pnvj-COhA7hBB6lM7pQ-ENBWbiE0UI87zcSCHwLOrrRYcDnk2Znu7q1a4G1MriJC4t3fxXLdHJ0JFXuGrE1dcQpbU9ho3WdEwFR1IoR9Mqf0Qmh" />
                            </div>
                            <button class="size-8 flex items-center justify-center text-gray-400 hover:text-primary">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                        </div>
                    </div>
                    <!-- Task Item 3 -->
                    <div
                        class="group flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-all shadow-sm">
                        <div
                            class="size-12 rounded-lg bg-gray-50 dark:bg-gray-700 flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                            <span class="text-[10px] font-bold uppercase">Oct</span>
                            <span class="text-lg font-extrabold leading-none">27</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-[10px] font-bold uppercase">Design
                                    System</span>
                                <span class="text-xs text-gray-400 font-medium">In 3 days</span>
                            </div>
                            <h3
                                class="font-bold text-[#101818] dark:text-white group-hover:text-primary transition-colors">
                                Submit Icon Set for Approval</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-full border-2 border-white dark:border-gray-800">
                                <img class="rounded-full w-full h-full object-cover" data-alt="Assignee avatar"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhMxPX0bruiN2O6POAyyxWEvkYkHfM9J4bEmJiPPul9tPhqMgb7u4sHchHDBGS3F-frRHHTqdAZ5Ct4OWlI9uCUzetvoz0RQGFmjq_9jYP7mwbFh1UojXtC_lwRkyydOTUYwEofnjOmgGii2KSOBU54bE34STDDOOyn-3zIVWHrvvdvthjyBxZ-VfIoOTxmBAzw65jvBJ4RaiQEMQlMW56S1wEd2QgIHp5fqMCfL0rwW1YR1ouZRyOC_5ZE15qjfsee0qrkphIsvgz" />
                            </div>
                            <button class="size-8 flex items-center justify-center text-gray-400 hover:text-primary">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                        </div>
                    </div>
                </div>
                <button
                    class="w-full mt-6 py-4 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl text-gray-400 font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">add_task</span>
                    Quick Add Task
                </button>
            </div>
            <!-- Recent Activity Column -->
            <div class="lg:col-span-1">
                <div class="flex items-center justify-between mb-6 px-1">
                    <h2 class="text-xl font-extrabold tracking-tight">Activity</h2>
                    <button class="text-gray-400 hover:text-primary">
                        <span class="material-symbols-outlined">more_horiz</span>
                    </button>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm overflow-hidden">
                    <div class="relative flex flex-col gap-6">
                        <!-- Vertical Timeline Line -->
                        <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-gray-100 dark:bg-gray-700"></div>
                        <!-- Activity Item 1 -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="relative z-10 size-6 rounded-full ring-4 ring-white dark:ring-gray-800 bg-primary/20 flex items-center justify-center">
                                <div class="size-2 rounded-full bg-primary"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-bold text-[#101818] dark:text-white">Sarah Chen</span> commented on
                                    <span class="text-primary font-medium hover:underline cursor-pointer">Homepage
                                        Redesign</span>
                                </p>
                                <div
                                    class="mt-2 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg text-xs text-gray-500 italic">
                                    "Looks great! Can we try a darker teal for the header?"
                                </div>
                                <p class="mt-1 text-[10px] text-gray-400 uppercase font-bold tracking-wider">24m ago</p>
                            </div>
                        </div>
                        <!-- Activity Item 2 -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="relative z-10 size-6 rounded-full ring-4 ring-white dark:ring-gray-800 bg-green-500/20 flex items-center justify-center">
                                <span class="material-symbols-outlined text-green-600 text-[14px] font-bold">check</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-bold text-[#101818] dark:text-white">Marcus Wu</span> completed <span
                                        class="text-primary font-medium hover:underline cursor-pointer">API
                                        Integration</span>
                                </p>
                                <p class="mt-1 text-[10px] text-gray-400 uppercase font-bold tracking-wider">1h ago</p>
                            </div>
                        </div>
                        <!-- Activity Item 3 -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="relative z-10 size-6 rounded-full ring-4 ring-white dark:ring-gray-800 bg-blue-500/20 flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-600 text-[14px]">swap_horiz</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-bold text-[#101818] dark:text-white">You</span> moved <span
                                        class="font-medium text-gray-700 dark:text-gray-200">User Research</span> to <span
                                        class="px-1.5 py-0.5 rounded bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-[10px] font-bold uppercase">Done</span>
                                </p>
                                <p class="mt-1 text-[10px] text-gray-400 uppercase font-bold tracking-wider">3h ago</p>
                            </div>
                        </div>
                        <!-- Activity Item 4 -->
                        <div class="relative flex items-start gap-4">
                            <div
                                class="relative z-10 size-6 rounded-full ring-4 ring-white dark:ring-gray-800 bg-amber-500/20 flex items-center justify-center">
                                <span class="material-symbols-outlined text-amber-600 text-[14px]">person_add</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-bold text-[#101818] dark:text-white">Julia Smith</span> joined the
                                    <span class="text-primary font-medium hover:underline cursor-pointer">Product
                                        Team</span>
                                </p>
                                <p class="mt-1 text-[10px] text-gray-400 uppercase font-bold tracking-wider">5h ago</p>
                            </div>
                        </div>
                    </div>
                    <button
                        class="w-full mt-8 py-2 text-sm font-bold text-gray-500 hover:text-primary transition-all flex items-center justify-center gap-1 group">
                        View Full Activity
                        <span
                            class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_right_alt</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>

@endsection
