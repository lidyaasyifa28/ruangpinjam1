<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket {{ $loan->ticket_number }} - RuangPinjam</title>
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

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <nav aria-label="Navigasi Utama" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <a href="{{ route('student.index') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer" alt="Logo RuangPinjam">
                <div class="flex flex-col">
                    <span class="text-base font-bold text-slate-900 tracking-tight leading-none">RuangPinjam</span>
                    <span class="text-[10px] font-medium text-slate-500 uppercase tracking-wider mt-0.5">Sarana &amp; Prasarana</span>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('student.pinjam') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs sm:text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Formulir Peminjaman</span>
                </a>
            </div>
        </nav>
    </header>

    <main class="flex-1 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        @if(session('success'))
            <div role="status" class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-xs sm:text-sm font-medium text-emerald-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div role="alert" class="mb-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-xs sm:text-sm font-medium text-rose-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @php
            $statusLabels = [
                'pending' => 'Menunggu Verifikasi',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'returned' => 'Selesai / Dikembalikan',
            ];
            $statusBadges = [
                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                'returned' => 'bg-slate-100 text-slate-700 border-slate-200',
            ];

            // Logika pengecekan pengingat tenggat waktu pengembalian sarpras
            $today = \Carbon\Carbon::today();
            $returnDateRaw = $loan->tanggal_kembali ?? $loan->return_date;
            $returnDate = $returnDateRaw ? \Carbon\Carbon::parse($returnDateRaw)->startOfDay() : null;
            $isSedangDipinjam = in_array(strtolower($loan->status), ['approved', 'sedang dipinjam'], true);
            $formattedReturnDate = $returnDate ? $returnDate->translatedFormat('d F Y') : '-';
        @endphp

        <!-- Notifikasi Pengingat Pengembalian Barang (Dinamis) -->
        @if($isSedangDipinjam && $returnDate)
            @if($returnDate->lt($today))
                <!-- Banner Merah: Tanggal Pengembalian Sudah Lewat -->
                <div role="alert" class="mb-6 rounded-lg border border-red-500 bg-red-100 p-4 text-xs sm:text-sm font-semibold text-red-800 shadow-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="flex-1">
                        <div class="font-bold text-red-900">TERLAMBAT: Tenggat waktu pengembalian telah lewat. Segera kembalikan barang!</div>
                        <p class="text-xs text-red-700 mt-1 font-normal">
                            Batas akhir pengembalian alat adalah tanggal <span class="font-semibold underline">{{ $formattedReturnDate }}</span>. Harap segera mengembalikan sarpras ke ruang pengelola Sarpras sekolah.
                        </p>
                    </div>
                </div>
            @elseif($returnDate->isToday() || $returnDate->isTomorrow())
                <!-- Banner Kuning: Tanggal Pengembalian Hari Ini atau Besok -->
                <div role="alert" class="mb-6 rounded-lg border border-yellow-300 bg-yellow-100 p-4 text-xs sm:text-sm font-semibold text-yellow-800 shadow-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <div class="font-bold text-yellow-900">
                            Peringatan: Harap kembalikan sarpras ke ruang admin paling lambat {{ $formattedReturnDate }}
                        </div>
                        <p class="text-xs text-yellow-700 mt-1 font-normal">
                            @if($returnDate->isToday())
                                Batas waktu pengembalian sarpras adalah <strong>HARI INI</strong>.
                            @else
                                Batas waktu pengembalian sarpras adalah <strong>BESOK</strong>.
                            @endif
                            Mohon pastikan alat dalam kondisi baik dan lengkap saat diserahkan.
                        </p>
                    </div>
                </div>
            @endif
        @endif

        <!-- Tiket Card -->
        <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <!-- Header Tiket -->
            <div class="border-b border-slate-200 bg-slate-50 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Bukti Pengajuan Digital</span>
                        </div>
                        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Detail Tiket Peminjaman</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Simpan nomor tiket ini untuk melacak status atau mencetak surat izin.</p>
                    </div>

                    <span class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-semibold border {{ $statusBadges[$loan->status] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                        {{ $statusLabels[$loan->status] ?? ucfirst($loan->status) }}
                    </span>
                </div>

                <!-- Nomor Tiket Box -->
                <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Nomor Tiket Resmi</span>
                        <div class="font-mono text-2xl font-bold text-indigo-600 mt-0.5">{{ $loan->ticket_number }}</div>
                    </div>
                    <div class="text-xs text-slate-500">
                        Diajukan pada: <strong class="text-slate-700">{{ $loan->created_at->format('d M Y, H:i') }} WIB</strong>
                    </div>
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6 sm:p-8 text-xs">
                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Penanggung Jawab / Peminjam</span>
                    <p class="mt-1 text-sm font-bold text-slate-900">{{ $loan->student_name }}</p>
                    <p class="mt-0.5 text-slate-500">{{ $loan->student_class }} &middot; {{ $loan->organization }}</p>
                    <p class="mt-1 text-indigo-600 font-medium">WhatsApp: {{ $loan->whatsapp }}</p>
                </div>

                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Sarana &amp; Prasarana</span>
                    <p class="mt-1 text-sm font-bold text-slate-900">{{ $loan->item->name ?? 'Inventaris Dihapus' }}</p>
                    <p class="mt-0.5 text-slate-500">{{ $loan->item->category ?? '-' }}</p>
                    <p class="mt-1 font-bold text-slate-700">Jumlah: {{ $loan->quantity }} Unit</p>
                </div>

                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Durasi Peminjaman</span>
                    <p class="mt-1 text-sm font-bold text-slate-900">
                        {{ $loan->borrow_date->format('d M Y') }} s/d {{ $loan->return_date->format('d M Y') }}
                    </p>
                    <p class="mt-0.5 text-slate-500">Wajib dikembalikan tepat waktu</p>
                </div>

                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Keperluan Kegiatan</span>
                    <p class="mt-1 text-slate-700 leading-relaxed font-medium">
                        {{ $loan->purpose }}
                    </p>
                </div>

                @if($loan->status === 'rejected' && $loan->rejection_reason)
                    <div class="sm:col-span-2 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-700">Alasan Penolakan Petugas:</span>
                        <p class="mt-1 text-sm font-medium">{{ $loan->rejection_reason }}</p>
                    </div>
                @endif
            </div>

            <!-- Footer Action -->
            <div class="border-t border-slate-200 bg-white p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('student.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-xs transition-colors">
                    Kembali ke Beranda
                </a>

                @if(in_array($loan->status, ['approved', 'returned'], true))
                    <div class="flex flex-wrap items-center gap-4 w-full sm:w-auto">
                        <a 
                            href="{{ route('student.loan.print', ['ticket_number' => $loan->ticket_number]) }}" 
                            target="_blank" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs transition-colors shadow-sm"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            <span>Cetak Surat Izin</span>
                        </a>

                        <a 
                            href="{{ route('student.loan.download', ['ticket_number' => $loan->ticket_number]) }}" 
                            download 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs shadow-sm transition-all"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Download PDF</span>
                        </a>
                    </div>
                @else
                    <span class="text-xs text-slate-500 text-center sm:text-right">
                        Surat izin dapat dicetak setelah pengelola menyetujui tiket ini.
                    </span>
                @endif
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} RuangPinjam &middot; Sistem Sarana &amp; Prasarana Sekolah.
        </div>
    </footer>

</body>
</html>