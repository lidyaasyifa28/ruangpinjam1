<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RuangPinjam - Peminjaman Sarpras Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- 1. Navbar -->
    <nav class="bg-indigo-700 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo-web.jpg') }}" class="w-10 sm:w-12 h-auto mix-blend-multiply transition-all duration-300 ease-out transform hover:scale-110 hover:rotate-3 cursor-pointer" alt="Logo RuangPinjam">
                <span class="text-2xl font-bold tracking-tight">RuangPinjam</span>
                <span class="bg-indigo-800 text-xs px-2.5 py-1 rounded-full font-medium">Sarana & Prasarana</span>
            </div>
            <div class="flex items-center space-x-6">
                <a href="#katalog" class="hidden md:inline-block text-sm text-indigo-100 hover:text-white transition">Katalog Alat</a>
                <a href="#layanan" class="hidden md:inline-block text-sm text-indigo-100 hover:text-white transition">Form & Status</a>
                <a href="{{ route('login') }}" class="text-xs sm:text-sm bg-white text-indigo-700 font-semibold px-4 py-2 rounded-lg hover:bg-indigo-50 transition shadow-sm">
                    Portal
                </a>
            </div>
        </div>
    </nav>

    <!-- 2. Hero Section & Alur Informasi Web (Bagian Atas) -->
    <section class="py-12 md:py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <div class="inline-flex items-center space-x-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs px-3.5 py-1.5 rounded-full font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Sistem Terintegrasi Sarpras Sekolah</span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Peminjaman Sarana Sekolah Lebih Cepat & Terdata
            </h1>

            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Ajukan peminjaman proyektor, kabel roll, mic wireless, dan perlengkapan sarpras lainnya secara transparan dengan bukti surat izin resmi.
            </p>

            <div class="pt-2 flex flex-wrap justify-center gap-3">
                <a href="{{ route('student.pinjam') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow transition">
                    Isi Formulir Peminjaman →
                </a>
                <a href="{{ route('student.katalog') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl border border-slate-200 transition">
                    Lihat Ketersediaan Alat
                </a>
            </div>

            <!-- 3 Langkah Alur Ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl mx-auto pt-8 text-left">
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-sm flex items-start space-x-3">
                    <span class="w-7 h-7 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-xs shrink-0">1</span>
                    <div>
                        <div class="font-bold text-sm text-slate-900">Pilih Alat & Isi Form</div>
                        <div class="text-xs text-slate-500 mt-0.5">Tentukan alat, durasi hari, dan keperluan kegiatan.</div>
                    </div>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-sm flex items-start space-x-3">
                    <span class="w-7 h-7 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-xs shrink-0">2</span>
                    <div>
                        <div class="font-bold text-sm text-slate-900">Verifikasi Pengelola</div>
                        <div class="text-xs text-slate-500 mt-0.5">Petugas sarpras meninjau jadwal & menyetujui tiket.</div>
                    </div>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-sm flex items-start space-x-3">
                    <span class="w-7 h-7 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-xs shrink-0">3</span>
                    <div>
                        <div class="font-bold text-sm text-slate-900">Cetak Surat & Ambil</div>
                        <div class="text-xs text-slate-500 mt-0.5">Cetak bukti izin dan serah terima alat di ruang sarpras.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
        
        <!-- Notifikasi Session -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-xl flex items-center justify-between shadow-sm">
                <span class="font-medium text-sm">{{ session('success') }}</span>
                <span class="text-xs bg-emerald-200 text-emerald-900 px-2.5 py-1 rounded font-semibold">Berhasil</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-300 text-rose-800 rounded-xl shadow-sm text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <!-- 3. Katalog Inventaris (Bagian Tengah) -->
        <section id="katalog" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Katalog Ketersediaan Sarpras</h2>
                    <p class="text-xs text-slate-500">Peralatan yang siap diajukan untuk operasional kegiatan sekolah.</p>
                </div>
                <span class="text-xs bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full font-medium border border-indigo-100 w-fit">
                    Real-time Data
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                @foreach($items as $item)
                    <div class="p-4 rounded-xl border border-slate-200/80 bg-slate-50/70 hover:bg-slate-50 transition flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-semibold text-indigo-600 uppercase tracking-wider">{{ $item->category }}</span>
                            <h3 class="font-bold text-slate-900 text-sm mt-0.5">{{ $item->name }}</h3>
                            <p class="text-xs text-slate-400 mt-1">Total Unit: {{ $item->stock_total }}</p>
                        </div>
                        <div class="text-right pl-3">
                            <span class="text-[10px] text-slate-500 block uppercase font-medium">Sisa</span>
                            <span class="text-xl font-extrabold {{ $item->stock_available > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $item->stock_available }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 4. Bagian Bawah: Form Peminjaman & Status Permohonan Berdampingan (2 Kolom) -->
        <section id="layanan" class="pt-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                
                <!-- KOLOM KIRI: FORMULIR PEMINJAMAN -->
                <div id="form-section" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-lg font-bold text-slate-900">Formulir Peminjaman Alat</h2>
                        <p class="text-xs text-slate-500 mt-1">Lengkapi data berikut dengan informasi penanggung jawab kegiatan.</p>
                    </div>

                    <form action="{{ route('student.loan.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Alat/Barang</label>
                            <select name="item_id" required class="w-full text-sm border-slate-300 border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-slate-50">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ $item->stock_available < 1 ? 'disabled' : '' }}>
                                        {{ $item->name }} (Sisa: {{ $item->stock_available }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Peminjam</label>
                                <input type="text" name="student_name" placeholder="Nama Lengkap" required class="w-full text-sm border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas</label>
                                <input type="text" name="student_class" placeholder="Contoh: XII PPLG 1" required class="w-full text-sm border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Organisasi/Ekskul</label>
                                <input type="text" name="organization" placeholder="OSIS/MPK/Pramuka" required class="w-full text-sm border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Nomor WhatsApp</label>
                                <input type="text" name="whatsapp" placeholder="08xxxxxxxxxx" required class="w-full text-sm border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Jumlah Unit</label>
                            <input type="number" name="quantity" min="1" value="1" required class="w-full text-sm border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Pinjam</label>
                                <input type="date" name="borrow_date" required class="w-full text-sm border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Kembali</label>
                                <input type="date" name="return_date" required class="w-full text-sm border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Tujuan / Keperluan Kegiatan</label>
                            <textarea name="purpose" rows="3" placeholder="Uraikan kegiatan peminjaman..." required class="w-full text-sm border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow shadow-indigo-600/20 text-sm">
                            Kirim Permohonan Peminjaman
                        </button>
                    </form>
                </div>

                <!-- KOLOM KANAN: STATUS PERMOHONAN TERKINI -->
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-lg font-bold text-slate-900">Status Permohonan Terkini</h2>
                        <p class="text-xs text-slate-500 mt-1">Pantau status tiket Anda dan cetak surat izin jika sudah disetujui.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-100 text-slate-600 font-semibold border-b">
                                <tr>
                                    <th class="py-3 px-3">Tiket</th>
                                    <th class="py-3 px-3">Peminjam</th>
                                    <th class="py-3 px-3">Barang</th>
                                    <th class="py-3 px-3">Status</th>
                                    <th class="py-3 px-3 text-right">Surat Izin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($recentLoans as $loan)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3 px-3 font-mono font-bold text-indigo-600">{{ $loan->ticket_number }}</td>
                                        <td class="py-3 px-3">
                                            <div class="font-medium text-slate-800">{{ $loan->student_name }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $loan->organization }} ({{ $loan->student_class }})</div>
                                        </td>
                                        <td class="py-3 px-3 text-slate-700">{{ $loan->item->name }} ({{ $loan->quantity }} unit)</td>
                                        <td class="py-3 px-3">
                                            @if($loan->status === 'pending')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800">Menunggu</span>
                                            @elseif($loan->status === 'approved')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">Disetujui</span>
                                            @elseif($loan->status === 'rejected')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-100 text-rose-800" title="{{ $loan->rejection_reason }}">Ditolak</span>
                                            @elseif($loan->status === 'returned')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            @if($loan->status === 'approved' || $loan->status === 'returned')
                                                <a href="{{ route('student.loan.print', $loan->ticket_number) }}" target="_blank" class="inline-block bg-slate-800 hover:bg-slate-900 text-white px-2.5 py-1 rounded text-[11px] font-medium transition">
                                                    Cetak Surat
                                                </a>
                                            @else
                                                <span class="text-slate-300 text-[11px]">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-slate-400">Belum ada data permohonan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        &copy; 2026 RuangPinjam — Sarana & Prasarana Sekolah.
    </footer>

</body>
</html>