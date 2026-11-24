@extends('layouts.admin')

@section('title', 'Dashboard Sarpras')
@section('page_title', 'Dashboard Sarana & Prasarana')
@section('page_subtitle', 'Ringkasan statistik dan aktivitas terkini sirkulasi inventaris sekolah.')

@section('content')
    <!-- 1. Ringkasan Statistik (4 Stat Cards: Responsive 1 col di mobile, 2 col di tablet, 4 col di desktop) -->
    <section aria-label="Statistik Peminjaman" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat 1: Total Peminjaman -->
        <div class="bg-white rounded-lg border border-slate-200 p-4 sm:p-5 shadow-sm min-w-0">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-semibold text-blue-700 uppercase tracking-wider truncate">Total Peminjaman</span>
                <span class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-2xl font-bold text-blue-900">{{ $totalLoansCount ?? $loans->total() }}</span>
                <span class="text-xs text-slate-500">Tiket terdaftar</span>
            </div>
            <p class="mt-2 text-[11px] text-slate-400 truncate">Akumulasi pengajuan siswa &amp; ekskul</p>
        </div>

        <!-- Stat 2: Menunggu Persetujuan -->
        <div class="bg-white rounded-lg border border-slate-200 p-4 sm:p-5 shadow-sm min-w-0">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider truncate">Menunggu Persetujuan</span>
                <span class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-2xl font-bold text-amber-600">{{ $pendingLoansCount ?? $loans->where('status', 'pending')->count() }}</span>
                <span class="text-xs text-slate-500">Perlu tindakan</span>
            </div>
            <p class="mt-2 text-[11px] text-slate-400 truncate">Verifikasi pengajuan baru</p>
        </div>

        <!-- Stat 3: Alat Terpinjam -->
        <div class="bg-white rounded-lg border border-slate-200 p-4 sm:p-5 shadow-sm min-w-0">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-semibold text-sky-700 uppercase tracking-wider truncate">Alat Terpinjam</span>
                <span class="w-8 h-8 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-2xl font-bold text-sky-700">{{ $activeBorrowedUnits ?? $loans->where('status', 'approved')->sum('quantity') }}</span>
                <span class="text-xs text-slate-500">Unit berstatus aktif</span>
            </div>
            <p class="mt-2 text-[11px] text-slate-400 truncate">Barang sedang digunakan di luar</p>
        </div>

        <!-- Stat 4: Total Aset -->
        <div class="bg-white rounded-lg border border-slate-200 p-4 sm:p-5 shadow-sm min-w-0">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider truncate">Total Aset</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-2xl font-bold text-emerald-700">{{ $items->sum('stock_total') }}</span>
                <span class="text-xs text-slate-500">Unit ({{ $items->count() }} jenis)</span>
            </div>
            <p class="mt-2 text-[11px] text-slate-400 truncate">Seluruh unit sarpras terdaftar</p>
        </div>
    </section>

    <!-- 2. Shortcut & Navigasi Cepat Antar Menu -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
        <!-- Shortcut ke Pengajuan -->
        <div class="bg-white border border-slate-200 rounded-lg p-4 sm:p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex items-center gap-3.5 min-w-0">
                <span class="w-10 h-10 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 truncate">Verifikasi Permohonan Pinjam</h3>
                    <p class="text-xs text-slate-500">Ada {{ $pendingLoansCount ?? $loans->where('status', 'pending')->count() }} tiket peminjaman baru menanti tindak lanjut.</p>
                </div>
            </div>
            <a href="{{ route('admin.persetujuan') }}" class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs transition-colors shadow-sm shadow-blue-500/20 shrink-0 self-start sm:self-auto">
                <span>Buka Persetujuan &rarr;</span>
            </a>
        </div>

        <!-- Shortcut ke Inventaris -->
        <div class="bg-white border border-slate-200 rounded-lg p-4 sm:p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex items-center gap-3.5 min-w-0">
                <span class="w-10 h-10 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 truncate">Kelola Inventaris &amp; Tambah Sarana</h3>
                    <p class="text-xs text-slate-500">Total {{ $items->count() }} jenis alat sarpras sekolah tercatat aktif.</p>
                </div>
            </div>
            <a href="{{ route('admin.inventaris') }}" class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-xs transition-colors shrink-0 self-start sm:self-auto">
                <span>Tambah Sarana &rarr;</span>
            </a>
        </div>
    </div>

    <!-- 3. Ringkasan Antrean Pengajuan Terbaru -->
    <section id="daftar-pengajuan" class="bg-white rounded-lg border border-slate-200 p-4 sm:p-6 shadow-sm min-w-0 scroll-mt-20">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-slate-200 mb-6">
            <div class="min-w-0">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Aktivitas Terbaru</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900 tracking-tight truncate">Daftar Pengajuan Peminjaman</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pantau dan kelola seluruh pengajuan peminjaman sarana sekolah dengan fitur pencarian dan paginasi.</p>
            </div>
            <a href="{{ route('admin.persetujuan') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition shrink-0 self-start sm:self-auto">
                Lihat Semua di Menu Persetujuan &rarr;
            </a>
        </div>

        <!-- Form Search Bar (Tailwind CSS, method GET, dengan ikon kaca pembesar) -->
        <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <form action="{{ route('admin.dashboard') }}#daftar-pengajuan" method="GET" class="w-full sm:max-w-md flex items-center gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nomor tiket atau nama peminjam..." 
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all shadow-xs"
                    >
                </div>
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs sm:text-sm rounded-lg transition-colors shadow-xs shadow-blue-500/20 shrink-0"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Cari</span>
                </button>
                @if(request('search'))
                    <a 
                        href="{{ route('admin.dashboard') }}#daftar-pengajuan" 
                        class="inline-flex items-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 font-medium text-xs sm:text-sm rounded-lg transition-colors shrink-0"
                        title="Hapus filter pencarian"
                    >
                        <span>Reset</span>
                    </a>
                @endif
            </form>

            <div class="text-xs text-slate-500 shrink-0">
                Menampilkan <span class="font-semibold text-slate-800">{{ $loans->firstItem() ?? 0 }}-{{ $loans->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800">{{ $loans->total() }}</span> data
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs min-w-[600px]">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-600 font-semibold">
                        <th class="py-3 px-4">No. Tiket</th>
                        <th class="py-3 px-4">Peminjam</th>
                        <th class="py-3 px-4">Barang &amp; Qty</th>
                        <th class="py-3 px-4">Jadwal Pinjam</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($loans as $loan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-600 text-sm">{{ $loan->ticket_number }}</span>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $loan->created_at ? $loan->created_at->format('d/m/Y H:i') : '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $loan->student_name }}</div>
                                <div class="text-[10px] text-slate-500">{{ $loan->student_class }} &middot; {{ $loan->organization }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-800">{{ $loan->item->name ?? '-' }}</div>
                                <div class="text-[10px] text-slate-500">{{ $loan->quantity }} unit</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400">s/d {{ \Carbon\Carbon::parse($loan->return_date)->format('d M Y') }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($loan->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">Menunggu</span>
                                @elseif($loan->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Sedang Dipinjam</span>
                                @elseif($loan->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">Ditolak</span>
                                @elseif($loan->status === 'returned')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">Selesai</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                @if($loan->status === 'approved')
                                    <div class="inline-flex items-center gap-2">
                                        <!-- Tombol Konfirmasi Barang Kembali (Pengembalian Manual Fisik) -->
                                        <form action="{{ route('admin.loan.return', $loan->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa barang fisik untuk tiket {{ $loan->ticket_number }} telah benar-benar diterima kembali?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs transition-colors shadow-sm shadow-blue-500/20">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>Konfirmasi Barang Kembali</span>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.persetujuan') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                            Tinjau &rarr;
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('admin.persetujuan') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                        Tinjau &rarr;
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                @if(request('search'))
                                    Tidak ditemukan pengajuan dengan kata kunci "<span class="font-semibold text-slate-600">{{ request('search') }}</span>".
                                @else
                                    Belum ada pengajuan pinjam.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4 pt-4 border-t border-slate-200">
            {{ $data->fragment('daftar-pengajuan')->links() }}
        </div>
    </section>

    <!-- Script pemeliharaan posisi scroll pada tabel daftar pengajuan -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('page') || window.location.hash === '#daftar-pengajuan') {
                const target = document.getElementById('daftar-pengajuan');
                if (target) {
                    target.scrollIntoView({ behavior: 'auto', block: 'start' });
                }
            }
        });
    </script>
@endsection