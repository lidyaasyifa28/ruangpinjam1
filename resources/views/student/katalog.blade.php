<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Sarana & Prasarana - RuangPinjam</title>
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
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- 1. Header / Navbar (Flat & Clean Corporate) -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <nav aria-label="Navigasi Utama" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('student.index') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer" alt="Logo RuangPinjam">
                <span class="text-base font-bold text-slate-900 tracking-tight">RuangPinjam</span>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ route('student.index') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Beranda</a>
                <a href="{{ route('student.katalog') }}" class="relative font-semibold text-indigo-600 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Lihat Katalog</a>
                <a href="{{ route('student.pinjam') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Isi Form</a>
                <a href="{{ url('/#alur') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Alur Layanan</a>
            </div>

            <!-- Single Portal Pengelola Button -->
            <div class="flex items-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs sm:text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Portal</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-8 border-b border-slate-200 mb-8">
            <div class="space-y-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                    Inventaris Sarpras
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Katalog Ketersediaan Sarana &amp; Prasarana</h1>
                <p class="text-sm text-slate-600 max-w-2xl font-normal">
                    Daftar peralatan sekolah yang siap diajukan untuk kegiatan pembelajaran, OSIS, ekstrakurikuler, dan acara resmi.
                </p>
            </div>
            
            <!-- CTA Button -->
            <div class="flex items-center gap-3">
                <a href="{{ route('student.pinjam') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition-colors">
                    <span>Ajukan Peminjaman</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Catalog Grid with Real Images -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $item)
                <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Real Image Container -->
                        <div class="relative w-full h-48 bg-slate-100 overflow-hidden border-b border-slate-200">
                            <img 
                                src="{{ !empty($item->image) ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=600&q=80' }}" 
                                alt="{{ $item->name }}" 
                                class="w-full h-48 object-cover bg-slate-200"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=600&q=80';"
                            >
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-xs font-semibold bg-white text-slate-800 border border-slate-200 shadow-sm">
                                {{ $item->category }}
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 space-y-4">
                            <div class="flex items-start justify-between gap-2">
                                <h2 class="text-base font-bold text-slate-900 line-clamp-1">
                                    {{ $item->name }}
                                </h2>
                                @if($item->stock_available > 0)
                                    <span class="shrink-0 inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="shrink-0 inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Habis
                                    </span>
                                @endif
                            </div>

                            <!-- Info Grid -->
                            <div class="grid grid-cols-2 gap-3 p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs">
                                <div>
                                    <span class="text-slate-500 block">Total Unit</span>
                                    <span class="font-bold text-slate-900 text-sm">{{ $item->stock_total }} Unit</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 block">Sisa Stok</span>
                                    <span class="font-bold {{ $item->stock_available > 0 ? 'text-emerald-700' : 'text-rose-600' }} text-sm">
                                        {{ $item->stock_available }} Unit
                                    </span>
                                </div>
                            </div>

                            <p class="text-xs text-slate-500 leading-relaxed font-normal">
                                Peralatan inventaris resmi sekolah dalam kondisi siap digunakan dan terawat.
                            </p>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="p-5 pt-0">
                        @if($item->stock_available > 0)
                            <a href="{{ route('student.pinjam', ['item_id' => $item->id]) }}" class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Pinjam Alat Ini</span>
                            </a>
                        @else
                            <button disabled class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg bg-slate-100 text-slate-400 font-medium text-sm cursor-not-allowed border border-slate-200">
                                <span>Unit Tidak Tersedia</span>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty State Clean Outline -->
                <div class="col-span-full py-16 text-center bg-white rounded-lg border border-dashed border-slate-300 p-8">
                    <div class="w-12 h-12 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Inventaris Terdata</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto font-normal">
                        Daftar peralatan akan otomatis muncul setelah pengelola menginputkan data inventaris sarana sekolah.
                    </p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer grayscale hover:grayscale-0" alt="Logo RuangPinjam">
                <span class="font-bold text-slate-800">RuangPinjam</span>
                <span>&copy; {{ date('Y') }} &middot; Unit Sarana &amp; Prasarana Sekolah</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('student.index') }}" class="hover:text-slate-900 transition-colors">Beranda</a>
                <a href="{{ route('student.katalog') }}" class="hover:text-slate-900 transition-colors">Lihat Katalog</a>
                <a href="{{ route('student.pinjam') }}" class="hover:text-slate-900 transition-colors">Isi Form</a>
                <a href="{{ route('login') }}" class="hover:text-slate-900 transition-colors">Portal Pengelola</a>
            </div>
        </div>
    </footer>

</body>
</html>
