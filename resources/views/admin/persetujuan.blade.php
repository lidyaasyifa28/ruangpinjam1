@extends('layouts.admin')

@section('title', 'Persetujuan Peminjaman')
@section('page_title', 'Verifikasi & Persetujuan Peminjaman')
@section('page_subtitle', 'Tinjau permohonan peminjaman, lakukan verifikasi, setujui, tolak, atau konfirmasi pengembalian alat.')

@section('content')
    <!-- Status Counters (Lebih Berwarna & Tema Biru) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white border border-blue-200 rounded-lg p-4 shadow-sm bg-blue-50/40">
            <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Total Pengajuan</span>
            <div class="text-xl font-bold text-blue-900 mt-1">{{ $totalLoansCount ?? $loans->total() }}</div>
        </div>
        <div class="bg-white border border-amber-200 rounded-lg p-4 shadow-sm bg-amber-50/30">
            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700">Menunggu Tindakan</span>
            <div class="text-xl font-bold text-amber-600 mt-1">{{ $pendingLoansCount ?? $loans->where('status', 'pending')->count() }}</div>
        </div>
        <div class="bg-white border border-emerald-200 rounded-lg p-4 shadow-sm bg-emerald-50/30">
            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Sedang Dipinjam</span>
            <div class="text-xl font-bold text-emerald-600 mt-1">{{ $approvedLoansCount ?? $loans->where('status', 'approved')->count() }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm bg-slate-50/50">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-600">Selesai Kembali</span>
            <div class="text-xl font-bold text-slate-700 mt-1">{{ $returnedLoansCount ?? $loans->where('status', 'returned')->count() }}</div>
        </div>
    </div>

    <!-- Card Header & Form Search Bar (Terpisah dari Tabel) -->
    <div id="antrean-peminjaman" class="bg-white rounded-lg border border-slate-200 p-4 sm:p-5 shadow-sm min-w-0 scroll-mt-20">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Daftar Lengkap</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Antrean Pengajuan Peminjaman Sarpras</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola status permohonan pinjam alat oleh siswa, guru, atau organisasi.</p>
            </div>
            <div class="text-xs text-slate-500 shrink-0">
                Menampilkan <span class="font-bold text-slate-800">{{ $loans->firstItem() ?? 0 }}-{{ $loans->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800">{{ $loans->total() }}</span> data
            </div>
        </div>

        <!-- Form Search Bar (method GET) -->
        <div class="mt-4">
            <form action="{{ route('admin.persetujuan') }}#antrean-peminjaman" method="GET" class="w-full sm:max-w-md flex items-center gap-2">
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
                        href="{{ route('admin.persetujuan') }}#antrean-peminjaman" 
                        class="inline-flex items-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 font-medium text-xs sm:text-sm rounded-lg transition-colors shrink-0"
                        title="Reset Pencarian"
                    >
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Div Pelindung Tabel Mandiri -->
    <div class="w-full max-w-full overflow-x-auto relative bg-white shadow-sm sm:rounded-lg border border-gray-200">
        <table class="w-full text-left whitespace-nowrap text-xs">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50 text-slate-600 font-semibold">
                    <th class="py-3 px-4">No. Tiket</th>
                    <th class="py-3 px-4">Peminjam &amp; Kontak</th>
                    <th class="py-3 px-4">Barang &amp; Qty</th>
                    <th class="py-3 px-4">Jadwal Pinjam</th>
                    <th class="py-3 px-4">Keperluan</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($loans as $loan)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <!-- Tiket -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span class="font-mono font-bold text-blue-600 text-sm">
                                {{ $loan->ticket_number }}
                            </span>
                            <div class="text-[10px] text-slate-400 mt-0.5">
                                {{ $loan->created_at ? $loan->created_at->format('d/m/Y H:i') : '-' }}
                            </div>
                        </td>

                        <!-- Peminjam & Kontak -->
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-900">{{ $loan->student_name }}</div>
                            <div class="text-[10px] text-slate-500">{{ $loan->student_class }} &middot; {{ $loan->organization }}</div>
                            <div class="text-[10px] text-blue-600 mt-0.5 font-medium">WA: {{ $loan->whatsapp }}</div>
                        </td>

                        <!-- Barang & Qty -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-semibold text-slate-800">{{ $loan->item->name ?? '-' }}</div>
                            <div class="text-[10px] text-slate-500">Jumlah: <span class="font-bold text-slate-700">{{ $loan->quantity }} unit</span></div>
                            <div class="text-[10px] text-slate-400">Sisa stok: {{ $loan->item->stock_available ?? 0 }}</div>
                        </td>

                        <!-- Jadwal -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-medium text-slate-800">
                                {{ \Carbon\Carbon::parse($loan->borrow_date)->format('d M Y') }}
                            </div>
                            <div class="text-[10px] text-slate-400">
                                s/d {{ \Carbon\Carbon::parse($loan->return_date)->format('d M Y') }}
                            </div>
                        </td>

                        <!-- Keperluan -->
                        <td class="py-3.5 px-4 max-w-[200px]">
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed" title="{{ $loan->purpose }}">
                                {{ $loan->purpose }}
                            </p>
                            @if($loan->status === 'rejected' && $loan->rejection_reason)
                                <p class="mt-1 text-[10px] text-rose-600 italic">
                                    Alasan: {{ $loan->rejection_reason }}
                                </p>
                            @endif
                        </td>

                        <!-- Status Badge -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            @if($loan->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    Menunggu
                                </span>
                            @elseif($loan->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Sedang Dipinjam
                                </span>
                            @elseif($loan->status === 'rejected')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200" title="{{ $loan->rejection_reason }}">
                                    Ditolak
                                </span>
                            @elseif($loan->status === 'returned')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    Selesai
                                </span>
                            @endif
                        </td>

                        <!-- Aksi Cepat -->
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            @if($loan->status === 'pending')
                                <div class="inline-flex items-center gap-2">
                                    <!-- Tombol Setujui -->
                                    <form action="{{ route('admin.loan.approve', $loan->id) }}" method="POST" onsubmit="return confirm('Setujui peminjaman tiket {{ $loan->ticket_number }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs transition-colors shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Setujui</span>
                                        </button>
                                    </form>

                                    <!-- Tombol Tolak -->
                                    <form action="{{ route('admin.loan.reject', $loan->id) }}" method="POST" onsubmit="let r = prompt('Masukkan alasan penolakan permohonan:', 'Jadwal bentrok atau alat sedang dalam pemeliharaan.'); if (!r) return false; this.querySelector('input[name=rejection_reason]').value = r; return true;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="rejection_reason" value="Jadwal bentrok atau alat sedang dalam pemeliharaan.">
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-medium text-xs transition-colors shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Tolak</span>
                                        </button>
                                    </form>
                                </div>
                            @elseif($loan->status === 'approved')
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

                                    <!-- Tombol Cetak & Download Dokumen -->
                                    <a href="{{ route('student.loan.print', $loan->ticket_number) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-xs transition-colors" title="Cetak Dokumen Lengkap">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        <span>Cetak</span>
                                    </a>
                                    <a href="{{ route('student.loan.download', $loan->ticket_number) }}" download class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs shadow-sm transition-all" title="Download Dokumen PDF">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>PDF</span>
                                    </a>
                                </div>
                            @elseif($loan->status === 'returned')
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('student.loan.print', $loan->ticket_number) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-xs transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        <span>Cetak Arsip</span>
                                    </a>
                                    <a href="{{ route('student.loan.download', $loan->ticket_number) }}" download class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs shadow-sm transition-all" title="Download Arsip PDF">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>PDF</span>
                                    </a>
                                </div>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            @if(request('search'))
                                Tidak ditemukan pengajuan dengan kata kunci "<span class="font-semibold text-slate-600">{{ request('search') }}</span>".
                            @else
                                Belum ada permohonan peminjaman yang masuk ke sistem.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Laravel di Luar Tabel -->
    <div class="mt-4">
        {{ $loans->fragment('antrean-peminjaman')->appends(request()->query())->links() }}
    </div>

    <!-- Script pemeliharaan posisi scroll pada tabel antrean data -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('page') || window.location.hash === '#antrean-peminjaman') {
                const target = document.getElementById('antrean-peminjaman');
                if (target) {
                    target.scrollIntoView({ behavior: 'auto', block: 'start' });
                }
            }
        });
    </script>
@endsection
