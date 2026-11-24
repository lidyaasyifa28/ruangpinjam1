<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Diskusi &amp; Pertanyaan - RuangPinjam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <nav aria-label="Navigasi Utama" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('student.index') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer" alt="Logo RuangPinjam">
                <span class="text-base font-bold text-slate-900 tracking-tight">RuangPinjam</span>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ route('student.index') }}" class="relative font-medium hover:text-slate-900 transition-colors">Beranda</a>
                <a href="{{ route('student.katalog') }}" class="relative font-medium hover:text-slate-900 transition-colors">Lihat Katalog</a>
                <a href="{{ route('student.pinjam') }}" class="relative font-medium hover:text-slate-900 transition-colors">Isi Form</a>
                <a href="{{ route('forum.index') }}" class="relative font-semibold text-indigo-600 transition-colors after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-[2px] after:bg-indigo-600">Papan Diskusi</a>
            </div>

            <!-- Single Portal Button -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs sm:text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-lg transition-colors shadow-xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Portal</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full space-y-12">
        
        <!-- Page Title & Header -->
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                Forum Siswa &amp; Sarpras
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Papan Diskusi &amp; Pertanyaan
            </h1>
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                Tanyakan kendala, saran, atau alur seputar peminjaman fasilitas sekolah. Petugas sarpras akan merespons pertanyaan Anda di sini.
            </p>
        </div>

        <!-- Alert Notifikasi Berhasil -->
        @if(session('success'))
            <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <span class="font-semibold">Berhasil!</span> {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- BAGIAN ATAS: Form Input Pertanyaan Baru -->
        <section aria-labelledby="form-heading" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div>
                    <h2 id="form-heading" class="text-lg font-bold text-slate-900">Tulis Pertanyaan Baru</h2>
                    <p class="text-xs text-slate-500">Pertanyaan Anda akan dapat dilihat oleh seluruh pengunjung dan dijawab oleh admin.</p>
                </div>
            </div>

            <form action="{{ route('forum.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Pengirim -->
                <div>
                    <label for="nama_pengirim" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Lengkap / Identitas <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama_pengirim" 
                        id="nama_pengirim" 
                        value="{{ old('nama_pengirim') }}" 
                        placeholder="Contoh: Farhan - XI PPLG 2" 
                        required
                        maxlength="100"
                        class="w-full rounded-xl border @error('nama_pengirim') border-rose-300 bg-rose-50/50 @else border-slate-300 bg-white @enderror px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition"
                    >
                    @error('nama_pengirim')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Isi Pertanyaan -->
                <div>
                    <label for="isi_pertanyaan" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">
                        Isi Pertanyaan <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        name="isi_pertanyaan" 
                        id="isi_pertanyaan" 
                        rows="4" 
                        required
                        maxlength="2000"
                        placeholder="Tuliskan pertanyaan atau kendala yang Anda alami secara jelas..."
                        class="w-full rounded-xl border @error('isi_pertanyaan') border-rose-300 bg-rose-50/50 @else border-slate-300 bg-white @enderror px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition resize-y"
                    >{{ old('isi_pertanyaan') }}</textarea>
                    @error('isi_pertanyaan')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="flex items-center justify-end pt-2">
                    <button 
                        type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm transition-all shadow-sm hover:shadow"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Kirim Pertanyaan</span>
                    </button>
                </div>
            </form>
        </section>

        <!-- BAGIAN BAWAH: Daftar Card Diskusi (Grid) -->
        <section aria-labelledby="diskusi-heading" class="space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <h2 id="diskusi-heading" class="text-lg sm:text-xl font-bold text-slate-900">
                        Diskusi Terkini
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-200 text-slate-700">
                        {{ $forums->count() }}
                    </span>
                </div>
                <span class="text-xs text-slate-500">Urutan: Terbaru</span>
            </div>

            @if($forums->isEmpty())
                <!-- State Kosong -->
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Pertanyaan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                        Jadilah yang pertama menuliskan pertanyaan di papan diskusi ini menggunakan form di atas.
                    </p>
                </div>
            @else
                <!-- Grid Daftar Card Pertanyaan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($forums as $forum)
                        <article class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                            
                            <!-- Pertanyaan Siswa -->
                            <div>
                                <!-- Header Card: Nama Pengirim & Status -->
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($forum->nama_pengirim, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-sm text-slate-900 leading-tight">
                                                {{ $forum->nama_pengirim }}
                                            </h3>
                                            <time class="text-[11px] text-slate-400" datetime="{{ $forum->created_at->toIso8601String() }}">
                                                {{ $forum->created_at->diffForHumans() }}
                                            </time>
                                        </div>
                                    </div>

                                    @if($forum->jawaban_admin)
                                        <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Dijawab</span>
                                        </span>
                                    @else
                                        <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            <span>Menunggu</span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Konten Pertanyaan -->
                                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line mt-2">
                                    {{ $forum->isi_pertanyaan }}
                                </p>
                            </div>

                            <!-- Balasan Admin (Jika Tersedia) -->
                            @if($forum->jawaban_admin)
                                <div class="mt-5 pt-4 border-t border-slate-100">
                                    <div class="bg-indigo-50 border border-indigo-100/80 rounded-xl p-4">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <div class="w-5 h-5 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px] font-extrabold shrink-0">
                                                A
                                            </div>
                                            <span class="text-xs font-bold text-indigo-900">
                                                Tanggapan Pengelola Sarpras
                                            </span>
                                        </div>
                                        <p class="text-xs sm:text-sm text-indigo-950 leading-relaxed whitespace-pre-line">
                                            {{ $forum->jawaban_admin }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                        </article>
                    @endforeach
                </div>
            @endif
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white py-8 border-t border-slate-200 mt-12">
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
