<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RuangPinjam - Peminjaman Sarana Sekolah</title>
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
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-50">
        <nav aria-label="Navigasi Utama" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('student.index') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer" alt="Logo RuangPinjam">
                <span class="text-base font-bold text-slate-900 tracking-tight">RuangPinjam</span>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ route('student.index') }}" class="relative font-semibold text-indigo-600 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Beranda</a>
                <a href="{{ route('student.katalog') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Lihat Katalog</a>
                <a href="{{ route('student.pinjam') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Isi Form</a>
                <a href="{{ route('forum.index') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Diskusi</a>
                <a href="#alur" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Alur Layanan</a>
                <a href="#faq" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">FAQ</a>
            </div>

            <!-- Single Portal Button -->
            <div class="flex items-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs sm:text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-lg transition-colors shadow-xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Portal</span>
                </a>
            </div>
        </nav>
    </header>

    <main class="flex-1 bg-slate-50">
        <!-- 2. Hero Section (Clean Corporate Look with Soft Border) -->
        <section class="relative overflow-hidden bg-white border-b border-slate-200 py-16 md:py-24 shadow-sm z-0">
            <!-- Background Glow/Blob Decoration (Top) -->
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-indigo-200 to-blue-400 opacity-40 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>

            <!-- Background Glow/Blob Decoration (Bottom) -->
            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-indigo-200 to-blue-400 opacity-40 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Hero Content & CTAs -->
                <div class="max-w-3xl mx-auto space-y-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100/80 shadow-xs">
                        Sistem Manajemen Sarpras
                    </span>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Peminjaman Sarana Sekolah Lebih Cepat, Terdata, dan Modern
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl">
                        Ajukan peminjaman proyektor, audio sound, kamera, dan inventaris sarpras sekolah lainnya secara digital tanpa formulir fisik. Pantau persetujuan real-time dengan surat izin resmi.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="pt-2 flex flex-wrap items-center gap-3">
                        <a href="{{ route('student.pinjam') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm shadow-sm hover:shadow transition-all">
                            <span>Mulai Pinjam Alat</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="{{ route('student.katalog') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-medium text-sm transition-colors shadow-xs">
                            <span>Lihat Katalog</span>
                        </a>
                    </div>

                    <!-- Micro-Checklist -->
                    <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-y-3 gap-x-6 text-xs text-slate-600">
                        <div class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-medium">100% Digital</span>
                        </div>
                        <div class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-medium">Terverifikasi Petugas</span>
                        </div>
                        <div class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-medium">Bukti Cetak Resmi</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 3. Showcase Section: Peralatan Populer Siap Pakai (bg-slate-50 py-20) -->
        <section class="bg-slate-50 py-20 border-b border-slate-200">
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto w-full">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-6 border-b border-slate-200/80 mb-6">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Peralatan Populer Siap Pakai</h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Koleksi Alat Tersedia &middot; Inventaris terawat dan siap pakai</p>
                        </div>
                        <span class="inline-flex self-start sm:self-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            Tersedia
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse($items->take(3) as $item)
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:-translate-y-2 hover:shadow-xl hover:border-indigo-400 transition-all duration-300 ease-in-out cursor-pointer p-4 sm:p-5 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3.5 sm:gap-4 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-indigo-50 border border-indigo-100/80 flex items-center justify-center text-indigo-600 shrink-0">
                                        @php
                                            $cat = strtolower($item->category ?? $item->kategori ?? '');
                                        @endphp
                                        @if(str_contains($cat, 'multi') || str_contains($cat, 'kamera') || str_contains($cat, 'proyektor'))
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        @elseif(str_contains($cat, 'audio') || str_contains($cat, 'sound') || str_contains($cat, 'mic'))
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M11 5L6 9H2v6h4l5 4V5z" />
                                            </svg>
                                        @elseif(str_contains($cat, 'listrik') || str_contains($cat, 'kabel') || str_contains($cat, 'daya'))
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm sm:text-base font-bold text-slate-900 truncate">{{ $item->name ?? $item->nama_barang }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $item->category ?? $item->kategori ?? 'Inventaris' }}</div>
                                    </div>
                                </div>
                                @if(($item->stock_available ?? $item->stok ?? 0) > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 shrink-0">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        @empty
                            <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-sm text-slate-500">
                                Belum ada peralatan terdata.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center justify-between text-xs sm:text-sm">
                        <span class="text-slate-500 font-medium">Total terdata: {{ $items->count() }} jenis</span>
                        <a href="{{ route('student.katalog') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1.5 transition-colors">
                            <span>Lihat Semua Katalog</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Alur 3 Langkah Layanan (Alternating Clean White Section) -->
        <section id="alur" class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center space-y-2 mb-12">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        Alur Layanan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Tiga Langkah Mudah Peminjaman Sarpras
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600">
                        Proses pengajuan, verifikasi, dan serah terima sarana berjalan secara transparan dan tertib.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Step 1 -->
                    <div class="bg-slate-50/60 hover:bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-xs hover:shadow-lg hover:border-indigo-200 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 font-bold text-sm flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                01
                            </div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">1. Pilih Alat &amp; Isi Form</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Tentukan perlengkapan yang dibutuhkan, jumlah unit, dan tanggal kegiatan melalui formulir digital tanpa berkas fisik.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200/60 text-xs text-slate-500 font-medium">
                            Tahap 1: Pengajuan Siswa
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-slate-50/60 hover:bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-xs hover:shadow-lg hover:border-indigo-200 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 font-bold text-sm flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                02
                            </div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">2. Verifikasi Petugas</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Pengelola sarpras meninjau jadwal pemakaian, ketersediaan unit fisik, lalu menyetujui izin peminjaman di sistem.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200/60 text-xs text-slate-500 font-medium">
                            Tahap 2: Tinjauan Pengelola
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-slate-50/60 hover:bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-xs hover:shadow-lg hover:border-indigo-200 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 font-bold text-sm flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                03
                            </div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">3. Cetak Tiket &amp; Ambil Barang</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Dapatkan nomor tiket resmi, cetak bukti izin persetujuan, dan lakukan serah terima alat langsung di ruang sarana sekolah.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-200/60 text-xs text-slate-500 font-medium">
                            Tahap 3: Serah Terima
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Lacak Tiket Section (Tiered Slate-50 Background) -->
        <section id="cek-tiket" class="py-16 sm:py-20 bg-slate-50/80 border-b border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm hover:shadow-md transition-all">
                    <div class="text-center space-y-2 mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            Lacak Status Tiket
                        </span>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Cek Status Permohonan Anda</h2>
                        <p class="text-sm text-slate-600">
                            Masukkan nomor tiket unik yang telah Anda peroleh untuk mengetahui status persetujuan.
                        </p>
                    </div>

                    <form action="{{ route('student.ticket.lookup') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="relative w-full">
                            <input 
                                type="text" 
                                name="ticket_number" 
                                value="{{ old('ticket_number', request('ticket_number')) }}" 
                                placeholder="Contoh: RP-ABC123" 
                                required 
                                maxlength="12"
                                class="w-full bg-white border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl px-4 py-2.5 font-mono text-sm text-slate-900 placeholder:text-slate-400 outline-none uppercase font-semibold transition"
                            >
                        </div>
                        <button type="submit" class="w-full sm:w-auto shrink-0 inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition-all shadow-sm hover:shadow">
                            <span>Lacak Tiket</span>
                        </button>
                    </form>

                    @error('ticket_number')
                        <div class="mt-3 p-2.5 rounded-lg bg-rose-50 border border-rose-200 text-center">
                            <p class="text-xs font-medium text-rose-700">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>
        </section>

        <!-- 5. FAQ (Frequently Asked Questions) Section -->
        <section id="faq" class="relative z-20 py-16 sm:py-20 bg-white border-b border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
                <div class="max-w-2xl mx-auto text-center space-y-2 mb-10">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        Bantuan &amp; Tanya Jawab
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Frequently Asked Questions (FAQ)
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600">
                        Pertanyaan yang sering diajukan seputar alur peminjaman, nomor tiket, dan tata tertib sarpras sekolah.
                    </p>
                </div>

                <div class="max-w-3xl mx-auto mt-6 relative z-20">
                    <!-- FAQ 1 -->
                    <details class="group mb-4 bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden transition-all duration-200">
                        <summary class="cursor-pointer list-none flex justify-between items-center w-full p-4 select-none font-semibold text-slate-800 hover:bg-slate-50 transition-colors [&::-webkit-details-marker]:hidden">
                            <span class="text-sm sm:text-base pr-4">Bagaimana alur meminjam sarana sekolah?</span>
                            <svg class="w-5 h-5 text-slate-500 transition-transform duration-200 group-open:rotate-180 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <p class="px-4 pb-4 pt-2 text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                            Isi form pengajuan di web, salin Nomor Tiket yang muncul, dan pantau status persetujuan. Jika disetujui, ambil barang ke ruang admin.
                        </p>
                    </details>

                    <!-- FAQ 2 -->
                    <details class="group mb-4 bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden transition-all duration-200">
                        <summary class="cursor-pointer list-none flex justify-between items-center w-full p-4 select-none font-semibold text-slate-800 hover:bg-slate-50 transition-colors [&::-webkit-details-marker]:hidden">
                            <span class="text-sm sm:text-base pr-4">Mengapa saya harus menyimpan Nomor Tiket?</span>
                            <svg class="w-5 h-5 text-slate-500 transition-transform duration-200 group-open:rotate-180 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <p class="px-4 pb-4 pt-2 text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                            Nomor Tiket adalah syarat wajib untuk melihat status persetujuan peminjaman Anda di sistem.
                        </p>
                    </details>

                    <!-- FAQ 3 -->
                    <details class="group mb-4 bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden transition-all duration-200">
                        <summary class="cursor-pointer list-none flex justify-between items-center w-full p-4 select-none font-semibold text-slate-800 hover:bg-slate-50 transition-colors [&::-webkit-details-marker]:hidden">
                            <span class="text-sm sm:text-base pr-4">Apa yang terjadi jika saya terlambat mengembalikan barang?</span>
                            <svg class="w-5 h-5 text-slate-500 transition-transform duration-200 group-open:rotate-180 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <p class="px-4 pb-4 pt-2 text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                            Sistem akan memunculkan peringatan merah di tiket Anda, dan keterlambatan dapat memengaruhi persetujuan peminjaman Anda berikutnya.
                        </p>
                    </details>

                    <!-- FAQ 4 -->
                    <details class="group mb-4 bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden transition-all duration-200">
                        <summary class="cursor-pointer list-none flex justify-between items-center w-full p-4 select-none font-semibold text-slate-800 hover:bg-slate-50 transition-colors [&::-webkit-details-marker]:hidden">
                            <span class="text-sm sm:text-base pr-4">Apakah saya bisa membatalkan pengajuan pinjam?</span>
                            <svg class="w-5 h-5 text-slate-500 transition-transform duration-200 group-open:rotate-180 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <p class="px-4 pb-4 pt-2 text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                            Pengajuan hanya bisa dibatalkan dengan menghubungi langsung petugas Sarpras sambil menyebutkan Nomor Tiket Anda.
                        </p>
                    </details>
                </div>
            </div>
        </section>
    </main>

    <!-- 6. Footer -->
    <footer class="bg-white py-8 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer grayscale hover:grayscale-0" alt="Logo RuangPinjam">
                <span class="font-semibold text-slate-800">RuangPinjam</span>
                <span>&copy; {{ date('Y') }} &middot; Unit Sarana &amp; Prasarana Sekolah</span>
            </div>
            <div class="flex items-center gap-6">
                <span>Jam Layanan: Senin &ndash; Jumat (07.00 &ndash; 15.30 WIB)</span>
            </div>
        </div>
    </footer>

</body>
</html>