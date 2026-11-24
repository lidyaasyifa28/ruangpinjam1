@extends('layouts.admin')

@section('title', 'Laporan Rekapitulasi Peminjaman')
@section('page_title', 'Laporan Rekapitulasi Peminjaman')
@section('page_subtitle', 'Rekapitulasi sirkulasi dan riwayat peminjaman sarana sekolah berdasarkan rentang tanggal.')

@section('content')
    <!-- Notifikasi Error / Sukses jika ada -->
    @if(session('error'))
        <div class="p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Filter Rentang Tanggal (Start Date & End Date) -->
    <div class="bg-white rounded-lg border border-slate-200 p-4 sm:p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-col sm:flex-row sm:items-end gap-3 sm:gap-4">
            <div class="flex-1 min-w-[160px]">
                <label for="start_date" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Tanggal Mulai (Start Date)
                </label>
                <input 
                    type="date" 
                    id="start_date" 
                    name="start_date" 
                    value="{{ request('start_date', $startDate) }}"
                    class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-slate-800 shadow-2xs"
                    required
                >
            </div>

            <div class="flex-1 min-w-[160px]">
                <label for="end_date" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Tanggal Selesai (End Date)
                </label>
                <input 
                    type="date" 
                    id="end_date" 
                    name="end_date" 
                    value="{{ request('end_date', $endDate) }}"
                    class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-slate-800 shadow-2xs"
                    required
                >
            </div>

            <div class="flex items-center gap-2 pt-1 sm:pt-0">
                <button 
                    type="submit" 
                    class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-sm transition-colors cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>

                <a 
                    href="{{ route('admin.laporan') }}" 
                    class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs border border-slate-300 transition-colors"
                >
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Status Counters Berdasarkan Rentang Tanggal -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <!-- Stat 1: Total Peminjaman (Dinamis Sesuai Filter) -->
        <div class="bg-white border border-blue-200 rounded-lg p-4 shadow-sm bg-blue-50/40">
            <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Total Peminjaman ({{ $periodeText }})</span>
            <div class="text-xl font-bold text-blue-900 mt-1">{{ $totalLoans }}</div>
            <p class="text-[10px] text-slate-500 mt-1 truncate" title="Periode {{ $periodeText }}">Periode {{ $periodeText }}</p>
        </div>

        <!-- Stat 2: Selesai / Dikembalikan (Objek Export) -->
        <div class="bg-white border border-emerald-200 rounded-lg p-4 shadow-sm bg-emerald-50/30">
            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Selesai / Dikembalikan</span>
            <div class="text-xl font-bold text-emerald-600 mt-1">{{ $returnedCount }}</div>
            <p class="text-[10px] text-slate-500 mt-1">Siap diunduh ke Excel</p>
        </div>

        <!-- Stat 3: Sedang Dipinjam -->
        <div class="bg-white border border-sky-200 rounded-lg p-4 shadow-sm bg-sky-50/30">
            <span class="text-[11px] font-bold uppercase tracking-wider text-sky-700">Sedang Dipinjam</span>
            <div class="text-xl font-bold text-sky-600 mt-1">{{ $activeCount }}</div>
            <p class="text-[10px] text-slate-500 mt-1">Unit belum dikembalikan</p>
        </div>

        <!-- Stat 4: Menunggu Persetujuan -->
        <div class="bg-white border border-amber-200 rounded-lg p-4 shadow-sm bg-amber-50/30">
            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700">Menunggu Tindakan</span>
            <div class="text-xl font-bold text-amber-600 mt-1">{{ $pendingCount }}</div>
            <p class="text-[10px] text-slate-500 mt-1">Perlu diverifikasi</p>
        </div>
    </div>

    <!-- Tabel Rekapitulasi Laporan Peminjaman -->
    <section class="bg-white rounded-lg border border-slate-200 p-4 sm:p-6 shadow-sm min-w-0">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-200 mb-6">
            <div class="min-w-0">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Periode: {{ $periodeText }}</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Daftar Rekapitulasi Peminjaman</h2>
                <p class="text-xs text-slate-500 mt-0.5">Menampilkan seluruh permohonan pinjam alat sarana sekolah dalam rentang tanggal yang dipilih.</p>
            </div>

            <!-- Tombol Unduh Laporan Excel (bg-green-600) dengan parameter filter tanggal -->
            <a 
                href="{{ route('admin.laporan.export', ['start_date' => request('start_date', $startDate), 'end_date' => request('end_date', $endDate)]) }}" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold text-xs sm:text-sm shadow-sm transition-colors shrink-0 self-start sm:self-auto"
                title="Unduh data pengembalian periode {{ $periodeText }} ke format spreadsheet .xlsx"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Unduh Laporan Excel</span>
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs min-w-[700px]">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-600 font-semibold">
                        <th class="py-3 px-4">No. Tiket</th>
                        <th class="py-3 px-4">Peminjam &amp; Kontak</th>
                        <th class="py-3 px-4">Barang &amp; Qty</th>
                        <th class="py-3 px-4">Jadwal Pinjam</th>
                        <th class="py-3 px-4">Keperluan</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-slate-200">
                    @forelse($loans as $loan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-600 text-sm">{{ $loan->ticket_number }}</span>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $loan->created_at ? $loan->created_at->format('d/m/Y H:i') : '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $loan->student_name }}</div>
                                <div class="text-[10px] text-slate-500">{{ $loan->student_class }} &middot; {{ $loan->organization }}</div>
                                <div class="text-[10px] text-blue-600 font-medium">WA: {{ $loan->whatsapp }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-800">{{ $loan->item->name ?? '-' }}</div>
                                <div class="text-[10px] text-slate-500">{{ $loan->quantity }} unit</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d M Y') }}</div>
                                <div class="text-[10px] text-slate-400">s/d {{ \Carbon\Carbon::parse($loan->return_date)->format('d M Y') }}</div>
                            </td>
                            <td class="py-3.5 px-4 max-w-[220px]">
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed" title="{{ $loan->purpose }}">
                                    {{ $loan->purpose }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($loan->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">Menunggu</span>
                                @elseif($loan->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Disetujui</span>
                                @elseif($loan->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">Ditolak</span>
                                @elseif($loan->status === 'returned')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Tidak ada data peminjaman untuk periode {{ $periodeText }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
        <div class="mt-4 pt-4 border-t border-slate-200">
            {{ $loans->links() }}
        </div>
    </section>
@endsection
