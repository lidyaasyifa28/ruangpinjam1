<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Pengelola Sarpras') - RuangPinjam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- 1. WRAPPER UTAMA (Flex, h-screen, overflow-hidden agar sidebar & main layout tidak bertabrakan) -->
    <div class="flex h-screen overflow-hidden bg-slate-50">

        <!-- 3. OVERLAY BACKGROUND (Muncul saat sidebar terbuka di layar mobile) -->
        <div id="sidebar-overlay" class="bg-slate-900/50 fixed inset-0 z-40 hidden transition-opacity"></div>

        <!-- 2. RESPONSIVE SIDEBAR (Sliding di mobile, statis di desktop) -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out bg-white bg-gradient-to-b from-white via-slate-50/50 to-blue-50/30 text-slate-700 overflow-y-auto flex flex-col justify-between p-5 border-r border-blue-100/90 shadow-xs shrink-0">
            <div>
                <!-- Top decorative colorful bar -->
                <div class="h-1.5 -mx-5 -mt-5 mb-5 bg-gradient-to-r from-blue-600 via-sky-400 to-indigo-500 shrink-0"></div>

                <!-- Brand & Logo + Close Button (Mobile) -->
                <div class="flex items-center justify-between pb-5 border-b border-blue-100/70 pt-1">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3">
                        <div class="p-1.5 rounded-xl bg-blue-50 border border-blue-100 shadow-2xs group-hover:scale-105 transition-transform">
                            <img src="{{ asset('images/logo-web.jpg') }}" class="w-8 h-auto mix-blend-multiply" alt="Logo RuangPinjam">
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base font-extrabold text-blue-950 tracking-tight leading-tight">RuangPinjam</span>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                <span class="text-[11px] font-semibold text-blue-600">Panel Pengelola Sarpras</span>
                            </div>
                        </div>
                    </a>
                    <!-- Tombol tutup sidebar (Khusus Mobile) -->
                    <button id="sidebar-close-btn" type="button" class="md:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors" aria-label="Tutup Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links (Multi-page Routes with Colorful Badges) -->
                <nav class="mt-6 space-y-1.5 text-xs font-semibold">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-blue-600/70 px-3 mb-2">Navigasi Utama</div>

                    <!-- 1. Dashboard -->
                    <a 
                        href="{{ route('admin.dashboard') }}" 
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold shadow-md shadow-blue-500/25' : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 font-medium' }}"
                    >
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'bg-blue-100/80 text-blue-600 group-hover:bg-blue-600 group-hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </span>
                        <span>Dashboard</span>
                    </a>

                    <!-- 2. Pengajuan Pinjam -->
                    <a 
                        href="{{ route('admin.persetujuan') }}" 
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.persetujuan') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold shadow-md shadow-blue-500/25' : 'text-slate-600 hover:text-sky-900 hover:bg-sky-50/80 font-medium' }}"
                    >
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-all {{ request()->routeIs('admin.persetujuan') ? 'bg-white/20 text-white' : 'bg-sky-100/80 text-sky-600 group-hover:bg-sky-600 group-hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <span>Pengajuan Pinjam</span>
                    </a>

                    <!-- 3. Inventaris Sarpras -->
                    <a 
                        href="{{ route('admin.inventaris') }}" 
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.inventaris') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold shadow-md shadow-blue-500/25' : 'text-slate-600 hover:text-cyan-900 hover:bg-cyan-50/80 font-medium' }}"
                    >
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-all {{ request()->routeIs('admin.inventaris') ? 'bg-white/20 text-white' : 'bg-cyan-100/80 text-cyan-700 group-hover:bg-cyan-600 group-hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </span>
                        <span>Inventaris Sarpras</span>
                    </a>

                    <!-- 4. Laporan Rekapitulasi -->
                    <a 
                        href="{{ route('admin.laporan') }}" 
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.laporan*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold shadow-md shadow-blue-500/25' : 'text-slate-600 hover:text-emerald-900 hover:bg-emerald-50/80 font-medium' }}"
                    >
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-all {{ request()->routeIs('admin.laporan*') ? 'bg-white/20 text-white' : 'bg-emerald-100/80 text-emerald-700 group-hover:bg-emerald-600 group-hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <span>Laporan Rekapitulasi</span>
                    </a>

                    <!-- 4. Lihat Web Siswa -->
                    <a 
                        href="{{ route('student.index') }}" 
                        target="_blank" 
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:text-emerald-900 hover:bg-emerald-50/80 font-medium transition-all"
                    >
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 bg-emerald-100/80 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </span>
                        <span>Lihat Web Siswa</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom: User & Logout -->
            <div class="pt-4 border-t border-blue-100/80 mt-6">
                <div class="mb-3 p-2.5 rounded-xl bg-gradient-to-br from-blue-50 via-sky-50/50 to-blue-100/40 border border-blue-200/80 flex items-center gap-3 shadow-2xs">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-sky-500 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm shadow-blue-500/30">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-xs font-bold text-blue-950 truncate leading-tight">{{ auth()->user()->name ?? 'Administrator' }}</span>
                        <span class="block text-[10px] text-blue-600/80 font-medium truncate leading-tight">{{ auth()->user()->email ?? 'admin@sarpras.sch.id' }}</span>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-white hover:bg-rose-50 text-slate-600 hover:text-rose-600 border border-slate-200/90 hover:border-rose-200 text-xs font-semibold shadow-2xs transition-all">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- 3. MAIN CONTENT CONTAINER (Scrollable terpisah, min-w-0 mencegah teks meluber) -->
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            
            <!-- 1. MOBILE HEADER & HAMBURGER BUTTON (Khusus layar HP) -->
            <header class="md:hidden flex items-center justify-between bg-slate-900 p-4 text-white sticky top-0 z-30 shadow-md shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="p-1.5 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                        <img src="{{ asset('images/logo-web.jpg') }}" class="w-6 h-6 object-contain rounded-md" alt="Logo RuangPinjam">
                    </div>
                    <div class="min-w-0">
                        <span class="text-sm font-extrabold tracking-tight text-white block leading-tight truncate">RuangPinjam</span>
                        <span class="text-[10px] text-blue-400 font-medium block leading-tight truncate">Panel Pengelola Sarpras</span>
                    </div>
                </div>
                <button id="hamburger-btn" type="button" class="p-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors shrink-0" aria-label="Buka Menu Sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </header>

            <!-- DESKTOP / TABLET TOP BAR HEADER -->
            <header class="bg-white/95 backdrop-blur-sm border-b border-blue-100 min-h-16 py-3 px-4 sm:px-6 md:px-8 flex flex-wrap items-center justify-between gap-3 sticky top-0 z-20 shadow-2xs shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-1.5 h-6 bg-gradient-to-b from-blue-600 to-sky-400 rounded-full shrink-0"></div>
                    <div class="min-w-0">
                        <h1 class="text-base font-bold text-slate-900 leading-tight truncate">@yield('page_title', 'Dashboard Sarana & Prasarana')</h1>
                        <p class="text-xs text-slate-500 truncate">@yield('page_subtitle', 'Kelola dan pantau seluruh sirkulasi inventaris sekolah.')</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Sistem Aktif
                    </span>
                    <a href="{{ route('student.index') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg shadow-2xs transition-colors">
                        <span>Buka Portal Siswa</span>
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-6">
                <!-- Global Flash Alerts -->
                @if(session('success'))
                    <div role="status" class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-xs sm:text-sm font-medium text-emerald-800 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="truncate">{{ session('success') }}</span>
                        </div>
                        <span class="text-[10px] bg-emerald-200 text-emerald-900 px-2 py-0.5 rounded font-bold shrink-0">Berhasil</span>
                    </div>
                @endif

                @if(session('error'))
                    <div role="alert" class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-xs sm:text-sm font-medium text-rose-800 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="truncate">{{ session('error') }}</span>
                        </div>
                        <span class="text-[10px] bg-rose-200 text-rose-900 px-2 py-0.5 rounded font-bold shrink-0">Perhatian</span>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer Admin -->
            <footer class="bg-white border-t border-blue-100 py-4 px-4 sm:px-6 md:px-8 mt-auto text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-3 shrink-0">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer grayscale hover:grayscale-0" alt="Logo RuangPinjam">
                    <span class="font-bold text-blue-950">RuangPinjam</span>
                    <span>&middot; Panel Administrator Sarpras SMK Negeri 1 Ciomas</span>
                </div>
                <p>&copy; {{ date('Y') }} RuangPinjam Sekolah. Hak cipta dilindungi.</p>
            </footer>
        </div>
    </div>

    <!-- 4. JAVASCRIPT TOGGLE (Vanilla JS Toggle Responsive Sidebar & Overlay) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const hamburgerBtn = document.getElementById('hamburger-btn');
            const closeBtn = document.getElementById('sidebar-close-btn');

            function openSidebar() {
                if (sidebar) sidebar.classList.remove('-translate-x-full');
                if (overlay) overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
            }

            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', function () {
                    if (sidebar && sidebar.classList.contains('-translate-x-full')) {
                        openSidebar();
                    } else {
                        closeSidebar();
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && sidebar && !sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>
