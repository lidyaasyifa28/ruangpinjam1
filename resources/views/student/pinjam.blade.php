<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Peminjaman Sarpras - SMK Negeri 1 Ciomas</title>
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
                <div class="flex flex-col">
                    <span class="text-base font-bold text-slate-900 tracking-tight leading-none">RuangPinjam</span>
                    <span class="text-[10px] font-medium text-slate-500 uppercase tracking-wider mt-0.5">SMK Negeri 1 Ciomas</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ route('student.index') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Beranda</a>
                <a href="{{ route('student.katalog') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Lihat Katalog</a>
                <a href="{{ route('student.pinjam') }}" class="relative font-semibold text-indigo-600 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Isi Form</a>
                <a href="{{ url('/#alur') }}" class="relative font-medium hover:text-slate-900 transition-colors duration-300 after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 hover:after:w-full after:h-[2px] after:bg-indigo-600 after:transition-all after:duration-300 after:ease-in-out">Alur Layanan</a>
            </div>

            <!-- Single Portal Pengelola Button -->
            <div class="flex items-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs sm:text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-md transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Portal</span>
                </a>
            </div>
        </nav>
    </header>

    @php
        $activeLoan = $activeLoan ?? (session('success_loan') ?? session('loan'));
        if (is_array($activeLoan)) {
            $ticketNumber = $activeLoan['ticket_number'] ?? null;
            $id = $activeLoan['id'] ?? null;
            if ($ticketNumber) {
                $activeLoan = \App\Models\Loan::with('item')->where('ticket_number', $ticketNumber)->first();
            } elseif ($id) {
                $activeLoan = \App\Models\Loan::with('item')->find($id);
            }
        } elseif (is_string($activeLoan) || is_numeric($activeLoan)) {
            $activeLoan = \App\Models\Loan::with('item')
                ->where('ticket_number', (string) $activeLoan)
                ->orWhere('id', $activeLoan)
                ->first();
        } elseif ($activeLoan instanceof \App\Models\Loan) {
            $activeLoan->loadMissing('item');
        }
        $hasSessionLoan = !empty($activeLoan) && is_object($activeLoan);
    @endphp

    <!-- Main Container -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        
        <!-- Alerts -->
        @if(session('success'))
            <div role="status" class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 p-4 text-xs sm:text-sm font-medium text-emerald-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <span class="text-[10px] bg-emerald-200 text-emerald-900 px-2.5 py-0.5 rounded font-bold">Terkirim</span>
            </div>
        @endif

        @if(session('error'))
            <div role="alert" class="mb-6 rounded-md border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-rose-800 flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <span class="text-xs bg-rose-200 text-rose-900 px-2 py-0.5 rounded font-bold">Gagal</span>
            </div>
        @endif

        @if($errors->any())
            <div role="alert" class="mb-6 rounded-md border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-rose-800">
                <p class="font-bold">Mohon periksa kembali kolom formulir yang belum sesuai:</p>
                <ul class="list-disc list-inside mt-1.5 text-xs">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="{{ $hasSessionLoan ? 'grid grid-cols-1 lg:grid-cols-12 gap-8 items-start' : 'max-w-2xl mx-auto' }}">
            
            <!-- KOLOM: FORMULIR PEMINJAMAN FISIK RESMI -->
            <div class="{{ $hasSessionLoan ? 'lg:col-span-6' : '' }} bg-white border border-slate-200 rounded-md p-6 shadow-sm">
                <div class="border-b border-slate-200 pb-5 mb-6">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                        SMK Negeri 1 Ciomas &middot; Sarpras
                    </span>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Formulir Peminjaman Alat &amp; Sarpras</h1>
                    <p class="text-xs text-slate-500 mt-1">Formulir permohonan peminjaman inventaris sarana dan prasarana sekolah.</p>
                </div>

                <form action="{{ route('student.loan.store') }}" method="POST" id="loanForm" class="space-y-4">
                    @csrf

                    <!-- 2-Column Grid: Nama Peminjam & Kelas / Organisasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_peminjam" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nama Peminjam <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                id="nama_peminjam" 
                                type="text" 
                                name="nama_peminjam" 
                                value="{{ old('nama_peminjam', old('student_name')) }}" 
                                placeholder="Nama Lengkap Siswa / Peminjam" 
                                required 
                                maxlength="100"
                                pattern="^[a-zA-Z\.\']+(?:\s+[a-zA-Z\.\']+)+$"
                                title="Harap masukkan nama lengkap (minimal 2 kata)"
                                class="w-full rounded-md border border-slate-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-3.5 py-2.5 text-sm text-slate-800 outline-none transition"
                            >
                            @error('nama_peminjam')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                            @error('student_name')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="kelas_organisasi" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Kelas / Organisasi <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                id="kelas_organisasi" 
                                type="text" 
                                name="kelas_organisasi" 
                                value="{{ old('kelas_organisasi', old('student_class', old('organization'))) }}" 
                                placeholder="Contoh: XII PPLG 1 / OSIS" 
                                required 
                                maxlength="100"
                                class="w-full rounded-md border border-slate-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-3.5 py-2.5 text-sm text-slate-800 outline-none transition"
                            >
                            @error('student_class')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Barang & QTY (Selection Grid) & Kontak WA -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                        <div class="sm:col-span-6">
                            <label for="item_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Barang &amp; Perlengkapan <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                id="item_id" 
                                name="item_id" 
                                required 
                                class="w-full rounded-md border border-slate-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-3.5 py-2.5 text-sm text-slate-800 outline-none transition"
                            >
                                <option value="">-- Pilih Barang --</option>
                                @foreach($items as $item)
                                    <option 
                                        value="{{ $item->id }}" 
                                        {{ (string) old('item_id', $selectedItemId ?? '') === (string) $item->id ? 'selected' : '' }} 
                                        {{ $item->stock_available < 1 ? 'disabled' : '' }}
                                    >
                                        {{ $item->name }} &middot; {{ $item->category }} (Tersedia: {{ $item->stock_available }})
                                    </option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="quantity" class="block text-xs font-bold text-slate-700 mb-1.5">
                                QTY <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                id="quantity" 
                                type="number" 
                                name="quantity" 
                                value="{{ old('quantity', 1) }}" 
                                min="1" 
                                required 
                                class="w-full rounded-md border border-slate-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-3.5 py-2.5 text-sm text-slate-800 outline-none transition"
                            >
                            @error('quantity')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-4">
                            <label for="whatsapp" class="block text-xs font-bold text-slate-700 mb-1.5">
                                No. WhatsApp / Kontak <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                id="whatsapp" 
                                type="tel" 
                                name="whatsapp" 
                                value="{{ old('whatsapp', '081234567890') }}" 
                                placeholder="08xxxxxxxxxx" 
                                required 
                                maxlength="20"
                                class="w-full rounded-md border border-slate-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-3.5 py-2.5 text-sm text-slate-800 outline-none transition"
                            >
                            @error('whatsapp')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 2-Column Grid: Tgl Peminjaman & Tgl Pengambilan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tgl_peminjaman" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Tgl Peminjaman <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                id="tgl_peminjaman" 
                                type="date" 
                                name="tgl_peminjaman" 
                                value="{{ old('tgl_peminjaman', old('borrow_date', date('Y-m-d'))) }}" 
                                required 
                                class="w-full rounded-md border border-slate-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-3.5 py-2.5 text-sm text-slate-800 outline-none transition"
                            >
                            @error('borrow_date')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tgl_pengambilan" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Tgl Pengambilan / Selesai <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                id="tgl_pengambilan" 
                                type="date" 
                                name="tgl_pengambilan" 
                                value="{{ old('tgl_pengambilan', old('return_date', date('Y-m-d', strtotime('+1 day')))) }}" 
                                required 
                                class="w-full rounded-md border border-slate-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-3.5 py-2.5 text-sm text-slate-800 outline-none transition"
                            >
                            @error('return_date')
                                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Keperluan Kegiatan -->
                    <div>
                        <label for="keperluan" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Keperluan <span class="text-rose-500">*</span>
                        </label>
                        <textarea 
                            id="keperluan" 
                            name="keperluan" 
                            rows="3" 
                            placeholder="Jelaskan secara ringkas keperluan kegiatan yang membutuhkan sarana ini..." 
                            required 
                            class="w-full rounded-md border border-slate-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-3.5 py-2.5 text-sm text-slate-800 outline-none transition resize-y"
                        >{{ old('keperluan', old('purpose')) }}</textarea>
                        @error('keperluan')
                            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                        @error('purpose')
                            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hidden Inputs for Backend Sync Compatibility -->
                    <input type="hidden" name="student_name" id="student_name" value="{{ old('nama_peminjam', old('student_name')) }}">
                    <input type="hidden" name="student_class" id="student_class" value="{{ old('kelas_organisasi', old('student_class')) }}">
                    <input type="hidden" name="organization" id="organization" value="{{ old('kelas_organisasi', old('organization', 'Siswa SMKN 1 Ciomas')) }}">
                    <input type="hidden" name="borrow_date" id="borrow_date" value="{{ old('tgl_peminjaman', old('borrow_date', date('Y-m-d'))) }}">
                    <input type="hidden" name="return_date" id="return_date" value="{{ old('tgl_pengambilan', old('return_date', date('Y-m-d', strtotime('+1 day')))) }}">
                    <input type="hidden" name="purpose" id="purpose" value="{{ old('keperluan', old('purpose')) }}">

                    <!-- Tombol Submit -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 py-3 px-5 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition-colors shadow-sm"
                        >
                            <span>Kirim Permohonan Peminjaman</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- STATUS TIKET & PERMOHONAN (HANYA DITAMPILKAN JIKA ADA SESSION SETELAH SUBMIT) -->
            @if(session('success_loan') || session('loan'))
                @if($hasSessionLoan && is_object($activeLoan))
                    <div class="lg:col-span-6 space-y-6">
                        
                        <!-- Card Detail Tiket yang Baru Saja Diajukan -->
                        <div class="bg-white rounded-md border border-slate-200 p-6 sm:p-8 shadow-sm">
                            <div class="border-b border-slate-200 pb-5 mb-5 flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                <div>
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold mb-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Pengajuan Berhasil</span>
                                    </div>
                                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Detail Tiket Peminjaman Baru</h2>
                                    <p class="text-xs text-slate-500 mt-0.5">Permohonan Anda berhasil diajukan ke sistem sarpras sekolah.</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $activeLoan->status === 'approved' ? 'Disetujui' : ($activeLoan->status === 'rejected' ? 'Ditolak' : ($activeLoan->status === 'returned' ? 'Selesai' : 'Menunggu Verifikasi')) }}
                                </span>
                            </div>

                            <!-- Banner Peringatan -->
                            <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 mb-4 rounded-md text-sm">
                                <p class="font-medium">⚠️ PENTING: Harap salin dan simpan Nomor Tiket di bawah ini! Anda akan membutuhkannya untuk mengecek status persetujuan peminjaman.</p>
                            </div>

                            <!-- Nomor Tiket Box -->
                            <div class="p-4 rounded-md bg-indigo-50 border border-indigo-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Nomor Tiket Anda</span>
                                    <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                        <div class="font-mono text-2xl font-bold text-indigo-600">
                                            {{ $activeLoan->ticket_number }}
                                        </div>
                                        <button 
                                            type="button" 
                                            onclick="navigator.clipboard.writeText('{{ $activeLoan->ticket_number }}'); alert('Kode berhasil disalin!');" 
                                            class="inline-flex items-center gap-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1 rounded text-sm font-medium transition-colors cursor-pointer"
                                            title="Salin Nomor Tiket"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            <span>Salin Kode</span>
                                        </button>
                                    </div>
                                </div>
                                <a href="{{ route('student.ticket.show', $activeLoan->ticket_number) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                    <span>Buka Tiket Lengkap &rarr;</span>
                                </a>
                            </div>

                            <!-- Rincian Data Pengajuan -->
                            <div class="space-y-3 text-xs">
                                <div class="p-3.5 rounded-md bg-slate-50 border border-slate-200 flex justify-between items-center">
                                    <span class="text-slate-500">Peralatan Dipinjam</span>
                                    <strong class="text-slate-900">{{ $activeLoan->item->name ?? '-' }} ({{ $activeLoan->quantity }} Unit)</strong>
                                </div>
                                <div class="p-3.5 rounded-md bg-slate-50 border border-slate-200 flex justify-between items-center">
                                    <span class="text-slate-500">Penanggung Jawab</span>
                                    <span class="font-bold text-slate-900">{{ $activeLoan->student_name }} ({{ $activeLoan->student_class }})</span>
                                </div>
                                <div class="p-3.5 rounded-md bg-slate-50 border border-slate-200 flex justify-between items-center">
                                    <span class="text-slate-500">Organisasi / Ekskul</span>
                                    <span class="font-medium text-slate-800">{{ $activeLoan->organization }}</span>
                                </div>
                                <div class="p-3.5 rounded-md bg-slate-50 border border-slate-200 flex justify-between items-center">
                                    <span class="text-slate-500">No. WhatsApp</span>
                                    <span class="font-mono font-medium text-slate-800">{{ $activeLoan->whatsapp }}</span>
                                </div>
                                <div class="p-3.5 rounded-md bg-slate-50 border border-slate-200 flex justify-between items-center">
                                    <span class="text-slate-500">Jadwal Pinjam</span>
                                    <span class="font-semibold text-slate-800">
                                        {{ \Carbon\Carbon::parse($activeLoan->borrow_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($activeLoan->return_date)->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="p-3.5 rounded-md bg-slate-50 border border-slate-200">
                                    <span class="text-slate-500 block mb-1">Keperluan</span>
                                    <p class="text-slate-700 leading-relaxed font-medium">{{ $activeLoan->purpose }}</p>
                                </div>
                            </div>

                            <!-- Catatan & Tombol Cetak -->
                            <div class="mt-6 pt-5 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <p class="text-[11px] text-slate-500 font-normal">
                                    Simpan nomor tiket ini. Surat izin resmi dapat dicetak setelah permohonan disetujui pengelola.
                                </p>
                                @if(in_array($activeLoan->status, ['approved', 'returned'], true))
                                    <div class="flex flex-wrap items-center gap-4">
                                        <a 
                                            href="{{ route('student.loan.print', $activeLoan->ticket_number) }}" 
                                            target="_blank" 
                                            class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition-colors shadow-sm"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            <span>Cetak Formulir</span>
                                        </a>

                                        <a 
                                            href="{{ route('student.loan.download', $activeLoan->ticket_number) }}" 
                                            download 
                                            class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition-all"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            <span>Download PDF</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                @endif
            @endif

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer grayscale hover:grayscale-0" alt="Logo RuangPinjam">
                <span class="font-bold text-slate-800">RuangPinjam</span>
                <span>&copy; {{ date('Y') }} &middot; Unit Sarana &amp; Prasarana SMK Negeri 1 Ciomas</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('student.index') }}" class="hover:text-slate-900 transition-colors">Beranda</a>
                <a href="{{ route('student.katalog') }}" class="hover:text-slate-900 transition-colors">Lihat Katalog</a>
                <a href="{{ route('student.pinjam') }}" class="hover:text-slate-900 transition-colors">Isi Form</a>
                <a href="{{ route('login') }}" class="hover:text-slate-900 transition-colors">Portal Pengelola</a>
            </div>
        </div>
    </footer>

    <!-- Form Field Sync & Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('loanForm');
            if (!form) return;

            const nama = document.getElementById('nama_peminjam');
            const sName = document.getElementById('student_name');
            const kelasOrg = document.getElementById('kelas_organisasi');
            const sClass = document.getElementById('student_class');
            const sOrg = document.getElementById('organization');
            const tglPinjam = document.getElementById('tgl_peminjaman');
            const bDate = document.getElementById('borrow_date');
            const tglKembali = document.getElementById('tgl_pengambilan');
            const rDate = document.getElementById('return_date');
            const kep = document.getElementById('keperluan');
            const purp = document.getElementById('purpose');

            function sync() {
                if (nama && sName && nama.value) {
                    sName.value = nama.value.trim();
                }
                if (kelasOrg) {
                    const val = kelasOrg.value.trim();
                    if (sClass && val) sClass.value = val;
                    if (sOrg && val) sOrg.value = val;
                }
                if (tglPinjam && bDate && tglPinjam.value) {
                    bDate.value = tglPinjam.value;
                }
                if (tglKembali && rDate && tglKembali.value) {
                    rDate.value = tglKembali.value;
                }
                if (kep && purp && kep.value) {
                    purp.value = kep.value.trim();
                }
            }

            form.addEventListener('input', sync);
            form.addEventListener('change', sync);

            // Pencegatan onsubmit untuk validasi keperluan minimal 5 kata
            form.addEventListener('submit', function (e) {
                sync();

                var textareaValue = kep ? kep.value : '';
                var trimmedValue = textareaValue.trim();
                var wordCount = trimmedValue ? trimmedValue.split(/\s+/).length : 0;

                if (wordCount < 5) {
                    e.preventDefault();
                    alert("Harap jelaskan keperluan minimal dalam 5 kata.");
                    if (kep) {
                        kep.focus();
                    }
                    return false;
                }
            });

            sync();
        });
    </script>

</body>
</html>