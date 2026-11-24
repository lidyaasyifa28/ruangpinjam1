@extends('layouts.admin')

@section('title', 'Inventaris Sarpras')
@section('page_title', 'Manajemen Inventaris Sarana & Prasarana')
@section('page_subtitle', 'Kelola ketersediaan stok peralatan dan daftarkan sarana prasarana baru sekolah.')

@section('content')
    <!-- 1. Tambah Inventaris Alat Baru -->
    <section id="tambah-sarana" class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <div class="border-b border-slate-200 pb-5 mb-6">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-2">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Pendaftaran Aset</span>
            </div>
            <h2 class="text-lg font-bold text-slate-900 tracking-tight">Tambah Sarana &amp; Alat Baru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftarkan inventaris sarana prasarana baru ke dalam katalog sistem peminjaman.</p>
        </div>

        <form action="{{ route('admin.item.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label for="new_item_name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Peralatan <span class="text-rose-500">*</span></label>
                <input 
                    id="new_item_name"
                    type="text" 
                    name="name" 
                    placeholder="Contoh: Kamera DSLR Canon" 
                    required 
                    class="w-full bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 outline-none transition"
                >
            </div>
            <div>
                <label for="new_item_category" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Alat <span class="text-rose-500">*</span></label>
                <input 
                    id="new_item_category"
                    type="text" 
                    name="category" 
                    placeholder="Multimedia, Kelistrikan, Olahraga..." 
                    required 
                    class="w-full bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 outline-none transition"
                >
            </div>
            <div>
                <label for="new_item_stock" class="block text-xs font-bold text-slate-700 mb-1.5">Total Stok Awal <span class="text-rose-500">*</span></label>
                <input 
                    id="new_item_stock"
                    type="number" 
                    name="stock_total" 
                    min="1" 
                    value="1" 
                    required 
                    class="w-full bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg px-3.5 py-2.5 text-xs text-slate-800 outline-none transition"
                >
            </div>
            <div>
                <button 
                    type="submit" 
                    class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-4 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs transition-colors shadow-sm shadow-blue-500/20"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Simpan Inventaris</span>
                </button>
            </div>
        </form>
    </section>

    <!-- 2. Tabel Daftar Inventaris Sarpras -->
    <section class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-slate-200 mb-6">
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Katalog Master</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Daftar Inventaris Sarpras Terdaftar</h2>
                <p class="text-xs text-slate-500 mt-0.5">Seluruh unit peralatan dan sarana sekolah beserta status ketersediaan stok.</p>
            </div>
            <div class="text-xs text-slate-500">
                Total <span class="font-bold text-slate-800">{{ $items->count() }}</span> jenis alat
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-600 font-semibold">
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Nama Sarana &amp; Peralatan</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4 text-center">Total Stok</th>
                        <th class="py-3 px-4 text-center">Stok Tersedia</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($items as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 text-sm">{{ $item->name }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                {{ $item->stock_total }} Unit
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="font-bold {{ $item->stock_available > 0 ? 'text-blue-600' : 'text-rose-600' }}">
                                    {{ $item->stock_available }} Unit
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($item->stock_available > 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Siap Dipinjam
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        Stok Habis
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada sarana prasarana yang terdaftar di sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
