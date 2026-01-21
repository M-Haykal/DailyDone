@extends('user.layouts.app')

@section('title', 'Projects')
@section('content')
    <div class="max-w-[1400px] mx-auto w-full">
        <!-- Page Heading -->
        <div class="flex items-end justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black tracking-tight">Recent Projects</h1>
                <p class="text-accent mt-1">Access your most frequent boards and keep track of progress.</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="flex items-center gap-2 px-4 py-2 shadow-sm rounded-lg text-sm font-bold bg-base-200 hover:bg-base-300">
                    <i class="fa-solid fa-arrow-down-1-9 text-lg"></i>
                    Filter
                </button>
            </div>
        </div>
        <!-- Tabs -->
        <div class="mb-8 border-b border-[#dae6e7] dark:border-[#1f3a3b]">
            <div class="flex gap-8">
                <a class="pb-3 border-b-2 border-primary text-primary text-sm font-bold" href="#">Recent Boards</a>
                <a class="pb-3 border-b-2 border-transparent text-[#5e8b8d] hover:text-[#101818] dark:hover:text-white text-sm font-bold"
                    href="#">Starred</a>
                <a class="pb-3 border-b-2 border-transparent text-[#5e8b8d] hover:text-[#101818] dark:hover:text-white text-sm font-bold"
                    href="#">Archived</a>
            </div>
        </div>
        <!-- Project Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Create Board Card -->
            <div class="group cursor-pointer border-2 border-dashed border-[#dae6e7] dark:border-[#1f3a3b] rounded-xl aspect-video flex flex-col items-center justify-center gap-3 bg-white/50 dark:bg-white/5 hover:bg-white dark:hover:bg-white/10 hover:border-primary transition-all"
                onclick="my_modal_4.showModal()">
                <div
                    class="size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl font-bold">add</span>
                </div>
                <span class="font-bold text-sm text-primary">Create New Board</span>
                <p class="text-xs text-[#5e8b8d]">Start a new workspace</p>
            </div>
            <!-- Project Card 1 -->
            <div class="card-shadow bg-white dark:bg-[#1f3a3b] rounded-xl overflow-hidden cursor-pointer">
                <div class="h-28 bg-cover bg-center relative" data-alt="Blue abstract geometric pattern background"
                    style="background-image: linear-gradient(0deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 100%), url('https://lh3.googleusercontent.com/aida-public/AB6AXuBOihSWeaQCZx-XjNsOxQ-3SNHV_0HLZgOQ_GG9UALX_unF1XZY-Qgdkj-DI_gPriXOgwO_3gMRuhS8XBRxXEpOZJCkMne0JQSVkEYzYrAXz3NDTejogjH0dUgitu_3enSCsWEnkf0zBuKnFM-rzXkcccB-Y8hwPm5DRrYTY9WsEs1kr8TMAa8Vnt51HJwR7tZLe7Ig7tCEyVCrMj_fCGUSifbAt55QMJmW2VxolrYEHlrz8MCX5Elu3Eb8815_6HqNrCR6NvvmU0HZ')">
                    <div class="absolute top-3 right-3">
                        <span
                            class="material-symbols-outlined text-white text-lg opacity-0 hover:opacity-100 transition-opacity">star</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <h3 class="font-bold text-[#101818] dark:text-white mb-1">Marketing Q4</h3>
                        <span
                            class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold uppercase tracking-wider">Active</span>
                    </div>
                    <p class="text-xs text-[#5e8b8d] mb-4">Updated 2 hours ago</p>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <div class="size-6 rounded-full border-2 border-white dark:border-[#1f3a3b] bg-cover"
                                data-alt="Team member 1 thumbnail"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA0HVgZ6WnNgScLdBMrvKrd8VVGxeSADA3ZO2W9vbmETr2FXNKFQifMcONDSBvjpVBcgU7g_l9HIw0GdwONW_h_h9dFuwUf6NjnqD1LUfIy4UShhIhFi3p-rQI9aO_Y-1dyVL_JLi7SFpgcYD_Kr3sthtCvQYTC2CCcMtyv9NVgVE3gm72x9ngyfLMx1YAoVPghUT3lkpNfKH2E0DwZ4dvz8sDqJeSogo4P3eIG_ODYpznBpmcY9vrtladHmv4li3BT1oM6v3uP-TXd')">
                            </div>
                            <div class="size-6 rounded-full border-2 border-white dark:border-[#1f3a3b] bg-cover"
                                data-alt="Team member 2 thumbnail"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBu7qFugr-__PywfVHXucpEqXeqw1nDt4pE7AzfQL5CrNPq365PksHT0DonfwMQ3h6hGQclvA01JvMpEPwBP29jKQ5K3EM632BHZML3sDu-c3xxEe2kaWtiXwJd4CNrPn83u9XiN1EIQ-c5IlzW6CxZ-N6uYH62X9mzVr6SJR9UFMyhsQzp-FKYrFYHjXidMdQY_4XZZ05cYpErJsg_qa-_TM5pty-iE7A5PW4ywzFdyi0Cn81zz6bDp8j5hfQsSFUMR5LbzwnjUIYk')">
                            </div>
                            <div
                                class="size-6 rounded-full border-2 border-white dark:border-[#1f3a3b] bg-gray-100 flex items-center justify-center text-[8px] font-bold text-gray-500">
                                +3</div>
                        </div>
                        <div class="flex items-center gap-1 text-[#5e8b8d]">
                            <span class="material-symbols-outlined text-sm">list_alt</span>
                            <span class="text-xs font-medium">12/24</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project Card 2 -->
            <div class="card-shadow bg-white dark:bg-[#1f3a3b] rounded-xl overflow-hidden cursor-pointer">
                <div class="h-28 bg-cover bg-center relative" data-alt="Teal architectural design background"
                    style="background-image: linear-gradient(0deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 100%), url('https://lh3.googleusercontent.com/aida-public/AB6AXuA-tgUe-UkWBK-PA6ff-VzFXZufPLJGFvYP5LlyMH1KgWMugThGJHnwr9zLCtgQvh7cEar4MDzHGL_ADMYo8YFrjyJtqdtQUp4_6suyLrbFshs0HTcSpEHyNX2xTSwK6R8bfuSotz3saK3CCg__H_Z72yh49b4HBWRFWhzsnVyTLN15OZVHEUY_txYb6cuW6oVBxEBFAxGUx1Rdu9yXShxoHoYamdLOM_9az7MxNZmi-PBKNcit-5az3HJphJUA-h4feEhGTKuxTNvI')">
                    <div class="absolute top-3 right-3">
                        <span class="material-symbols-outlined text-yellow-400 text-lg fill-1">star</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-[#101818] dark:text-white mb-1">Product Roadmap</h3>
                    <p class="text-xs text-[#5e8b8d] mb-4">Updated yesterday</p>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <div class="size-6 rounded-full border-2 border-white dark:border-[#1f3a3b] bg-cover"
                                data-alt="Team member 3 thumbnail"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCuaMNofRCBzpjPdS1DUSDsV5-nfmRE7dtn7IjPGymeR6lusg_hvVqeicLZru_TTJgvM57tINU0ZFrwb_VsB1IMpR_J6JaCCN5U3esceMU9B_vkQVVdzDx6qr297ltHl_LyIckQu2LUGOVlUfWTNAjipoSAT4WxHLbHnUyfsMW2xptd61QwBS3HruqjXKYfuOGfx9qbJzx_SyfirA52x2sHd4t49aBEOIJSJ2TYf6cv8KGWVrWcdbcrUjXTS4bzm4m5Qugl2VL4_EEt')">
                            </div>
                            <div class="size-6 rounded-full border-2 border-white dark:border-[#1f3a3b] bg-cover"
                                data-alt="Team member 4 thumbnail"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBS_w5jf91CrSax70htUFrt95iCXvwYUOFPxtaURhH-lEThFYt2ZYyk9VGHvaj4m06CQWHNpa28LcCOsZOkxy-ioCRKXfXzkK9jwYM36KvzUKQoK_SWJlgG6CgdwPgl7CTDGD8e3vp273lSyELHTdilC40P-YVDd81O1HRo7NpBGBfqHxkvjYsCXiYLKVVtnJiIUujmrmVGIk1agSesrCzpSlNYyUvpnG245nygy00yhO165-mYdL55IRsI49F-7ObDr80wcbLOJS22')">
                            </div>
                        </div>
                        <div class="flex items-center gap-1 text-primary">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            <span class="text-xs font-bold">On Track</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project Card 3 -->
            <div class="card-shadow bg-white dark:bg-[#1f3a3b] rounded-xl overflow-hidden cursor-pointer">
                <div class="h-28 bg-cover bg-center relative" data-alt="Abstract vibrant gradient mesh background"
                    style="background-image: linear-gradient(0deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 100%), url('https://lh3.googleusercontent.com/aida-public/AB6AXuCIkBCjRKwP8AHgYvr2t78GEJ8rGUz6goymbDSHOBQEvTxGeuVXJWudBbtMoa8jwwajVkxV_f--d8qtiQjvJKPhO4msnlXxtpnHDdSwhPmDBfP74z2jHqxQ3Zelrs6q_aHzyo-zUzJ3GdHJ5W19W5NaK9Fp9mQ1sjH1Nfbl0lyIGzEbaExuR-bvcBJoxKNOzdyfrcFSNGDV2FslLEtV7T7a3VSaRl8gA_oK4qDUiaZT_27eRDVJk3soO-5tkwOtmi1Pf4GezrHtY44E')">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-[#101818] dark:text-white mb-1">Design System</h3>
                    <p class="text-xs text-[#5e8b8d] mb-4">Updated 3 days ago</p>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <div class="size-6 rounded-full border-2 border-white dark:border-[#1f3a3b] bg-cover"
                                data-alt="Team member 5 thumbnail"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAORtp1sWTDNtrldMiQIodPsNjOCHzFXhLCM1ze0pf_Mu4KNer698O1GnkH4HXlfL8l-7-QnO7yZCpLYnlSf-e4jJKCXLpSBACxwKuIXzhliY_cx0bzrl-Nb9ey2LF9b-CXaY4MCr7iGRyceMU4WyOXka2JKvKT0YbNOAXl9oBV-yhyrSwnJaLvA3r2klORPd9LjVDC01quCKvefL9mtFSDICYpohh4AxGWkQfqWPniF62k6mu6aPlXoG65LYOzGkX4Bhl2HTcG7iWk')">
                            </div>
                        </div>
                        <div class="flex items-center gap-1 text-[#5e8b8d]">
                            <span class="material-symbols-outlined text-sm">attachment</span>
                            <span class="text-xs font-medium">8 files</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project Card 4 -->
            <div class="card-shadow bg-white dark:bg-[#1f3a3b] rounded-xl overflow-hidden cursor-pointer">
                <div class="h-28 bg-cover bg-center relative" data-alt="Clean minimal dark theme desktop setup background"
                    style="background-image: linear-gradient(0deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 100%), url('https://lh3.googleusercontent.com/aida-public/AB6AXuAquQr-OPsFptYjG-hcHg3RCnWmMvaZlIGiL_uPHEZc0pn8xHqKr2f02EqXY_89y4ZrlO9zh_IVixiNMfH5KBaO0Q6cNYZokhhBWPKs2eWMmBbySAYoMMcN63AXsOAOsBntD7_7h3ZOCvE94kPWWrIwP4SByzphG9bF_11zOoLJTpFOL18UO_wx62YOY0vWQ0Sy3df4IYLd0WaE2qGdU3Sbc2S1mwezfkdil7iGbom_w4xyKc1YcPohqzHd-DTF-p4K55D1f0xt3AqS')">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-[#101818] dark:text-white mb-1">Website Redesign</h3>
                    <p class="text-xs text-[#5e8b8d] mb-4">Updated 1 week ago</p>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <div class="size-6 rounded-full border-2 border-white dark:border-[#1f3a3b] bg-cover"
                                data-alt="Team member 6 thumbnail"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDM9kyX5QDelM2vHlD7dELzzE-5E-LFWHPnQ-D7ehlCKzxWtaP2dXO_DqG9JfdAoK33x7mMu8cMmALPDhJy0Fxtn859U-HfbNBjLfYzHxHwM-u4eU6MxAd3E1Vg4-AWVtZL4CRunRlqiM1YlclbN5O92z89lmfjM_naauu_mJlky4WzlG0w8LMNa2bi8L7sOzvPkZKdXqdGvBtcudmiK6AfOylX8d79_uaJgA-lxRnJvz3Vmkn4GPA7v6zUFayy4aqOCmOIIMeYtu0T')">
                            </div>
                            <div class="size-6 rounded-full border-2 border-white dark:border-[#1f3a3b] bg-cover"
                                data-alt="Team member 7 thumbnail"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA5Hf5ZkVoYjWVujMy1yGDKlgHJHivTzPM39t8voePKOIIq3_p2j5jVRPluWE5dvzVVaa-RGmdioEYUA5huKqZb2BGzNOjYWsp8leTpgQim5ny_4KG_KcYu49BuQnphvaBjMtAqwLki1HGNrHo_xdTrgD873hRbyUutROOd9-kSjy-2cQo161rdIGUvyvl9DeX54hBPYTW31zJBEGRrfPenT-PunBs9VU5DvJGC2CdlHAvAwNcFZSefN-04qS3EwT7u0CBSJLnN21ZY')">
                            </div>
                        </div>
                        <div class="flex items-center gap-1 text-orange-500">
                            <span class="material-symbols-outlined text-sm">warning</span>
                            <span class="text-xs font-bold">At Risk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team Section -->
        <div class="mt-16 p-8 bg-white dark:bg-[#1f3a3b] rounded-2xl border border-[#dae6e7] dark:border-[#1f3a3b]">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-xl font-bold mb-1">Your Team is Online</h2>
                    <p class="text-[#5e8b8d] text-sm">Collaborate in real-time with your workspace members.</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-3">
                        <div class="size-10 rounded-full border-4 border-white dark:border-[#1f3a3b] relative">
                            <img alt="Team member" class="size-full rounded-full"
                                data-alt="Team member avatar with green online status dot"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDLwDD79p6mSV0NwhJ7x0djVVASNzZuxfC9Ipq7YAUqNKXQ-uTXAJTEXl9vdzl2nI1E3zyEaDm3SrXPq2ijv1dKovlZZHgH4gSW2up_R37svMLRQ3m_Bj2phV2i24ZzSeNpjxeCSdSozzjylHL14IL_oF0ycno4uPOQYWvdrGY2C8kLmgb78IWN4V9v35kDv4MLb-gk2Zk-KkG3RY_DNcvuISevaBbqUNvlsR846ElvaEeYLN3P-MDgblx8JEs7MtT9JLf_BAtzkMY-" />
                            <div
                                class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-white dark:border-[#1f3a3b] rounded-full">
                            </div>
                        </div>
                        <div class="size-10 rounded-full border-4 border-white dark:border-[#1f3a3b] relative">
                            <img alt="Team member" class="size-full rounded-full"
                                data-alt="Team member avatar with green online status dot"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDmw6aUhvlphCgghCYrIn3FlXSaOBAVkhbZL7qa9l2khYnWeldIkczhJiOlHC7FHyFvfV6FwCz3oDsUSm5Y8BWpn6j8fmVOT6CWebfjIQjmOC79sO1uAa3aYoBmrFpv4Sh-V_OcWrBCl17rEYZ3hyMFME4pBRCv16k_Y7itSu1JVyu3zEtTxTKQAbYt00FwKpm-4ciIdvyH8j70V7cloIkJsCsIOhsKpzVBhw2y17xo1_lG9bUcJrNX8Rslx1E_9fMp1YVwVuaKE2uw" />
                            <div
                                class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-white dark:border-[#1f3a3b] rounded-full">
                            </div>
                        </div>
                        <div class="size-10 rounded-full border-4 border-white dark:border-[#1f3a3b] relative">
                            <img alt="Team member" class="size-full rounded-full"
                                data-alt="Team member avatar with green online status dot"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDrd99bNekann_4RATGxb3YQ8I2CA36EzpRPI7OLc5Ouk5CbDVqHF-GJZLdn0J1QaSvF5QSp2QcasEfT7ZPlJgAdLktB6WtDOLEkGLn8YRpymoJRXH6ndqsFeXg3Ivso04RcUDFhDgo9u2YPcuWQr2au0PAuKREs9V0i2b9y9E6Yq_3Ce9bKpBxtx42sJM51GaS-wgpl8WgMn2TXNKTNWjphC5MRVAhdpsTVz77fQXMO6noeWxo0MCb2_rpCS2ngnEQjBpLb4-UfUjQ" />
                            <div
                                class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-white dark:border-[#1f3a3b] rounded-full">
                            </div>
                        </div>
                        <div
                            class="size-10 rounded-full border-4 border-white dark:border-[#1f3a3b] bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-400">
                            +12</div>
                    </div>
                    <button
                        class="px-6 py-2 bg-[#f0f5f5] dark:bg-primary/20 text-primary font-bold rounded-lg text-sm hover:bg-primary hover:text-white transition-all">
                        View Team
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('user.modal.projects.create')
@include('user.modal.projects.edit')
