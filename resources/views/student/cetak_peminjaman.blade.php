<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Barang / Ruang - SMK Negeri 1 Ciomas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm 15mm 12mm 15mm;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .a4-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }
            input, textarea {
                border-bottom: 1px solid #000000 !important;
                color: #000000 !important;
            }
            table, th, td {
                border-color: #000000 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 py-6 sm:py-10 text-black antialiased min-h-screen">

    <!-- Top Action Bar (No Print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <a href="{{ url()->previous() ?? route('student.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-md transition-colors shadow-sm">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>

        <div class="flex items-center gap-4">
            <span class="text-xs text-slate-500 hidden sm:inline">Format Resmi Dokumen A4 Fisik (Form 1)</span>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak (Ctrl+P)</span>
            </button>
            <a href="{{ route('student.loan.download', ['ticket_number' => $loan->ticket_number, 'type' => 'form']) }}" download class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Download PDF</span>
            </a>
        </div>
    </div>

    <!-- Container: A4 Paper Style -->
    <div class="a4-container max-w-4xl mx-auto bg-white p-8 md:p-12 shadow text-black text-sm leading-normal">
        
        <!-- Header (KOP Surat Resmi SMKN 1 Ciomas) -->
        <header class="border-b-4 border-black pb-4 mb-6">
            <div class="flex justify-between items-center gap-4">
                <!-- Kiri: Logo Bogor / Jabar -->
                <img src="{{ asset('images/logo-bogor.png') }}" alt="Logo Daerah" class="w-24 h-auto object-contain">

                <!-- Tengah: Teks Kop Surat -->
                <div class="flex-1 text-center">
                    <h3 class="text-xs sm:text-sm font-semibold tracking-wider uppercase text-black leading-tight">
                        PEMERINTAH DAERAH PROVINSI JAWA BARAT
                    </h3>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight uppercase text-black mt-0.5 leading-tight">
                        SMK NEGERI 1 CIOMAS
                    </h2>
                    <p class="text-[11px] sm:text-xs text-black mt-1 leading-relaxed font-normal">
                        Jl. Raya Laladon, Ds. Laladon, Kecamatan Ciomas, Kabupaten Bogor<br>
                        Bogor – Jawa Barat 16610; Telpon (0251) 7520933<br>
                        e-mail : smkn1_ciomas@yahoo.co.id; web : www.smkn1ciomas.sch.id
                    </p>
                </div>

                <!-- Kanan: Logo SMK -->
                <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Ciomas" class="w-24 h-auto object-contain">
            </div>
        </header>

        <!-- Judul & Nomor Dokumen -->
        <div class="my-4 text-left">
            <h1 class="text-sm sm:text-base font-bold text-black underline underline-offset-4 tracking-tight">
                Form Peminjaman Barang/ Ruang
            </h1>
            <p class="text-xs sm:text-sm font-medium mt-1 text-black">
                Nomor.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="{{ isset($loan) ? $loan->ticket_number : '' }}" class="border-b border-black bg-transparent px-1 focus:outline-none font-mono text-center w-28 text-xs sm:text-sm" placeholder=".........."> /Peminjaman/Sarpras /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="{{ date('m') }}" class="border-b border-black bg-transparent px-1 focus:outline-none text-center w-10 text-xs sm:text-sm" placeholder="...."> /2026
            </p>
        </div>

        <!-- Main Table (Barang / Ruang) -->
        <table class="w-full border-collapse border border-black mt-4 text-xs sm:text-sm">
            <thead>
                <tr class="text-black border-b border-black font-bold text-center">
                    <th rowspan="2" class="border border-black py-2 px-2 text-center w-12 align-middle">No</th>
                    <th rowspan="2" class="border border-black py-2 px-3 text-center align-middle">Nama Barang/<br>Ruang</th>
                    <th rowspan="2" class="border border-black py-2 px-2 text-center w-16 align-middle">QTY</th>
                    <th colspan="2" class="border border-black py-1 px-2 text-center align-middle">Kondisi</th>
                    <th rowspan="2" class="border border-black py-2 px-3 text-center w-24 align-middle">Koordinasi</th>
                    <th rowspan="2" class="border border-black py-2 px-2 text-center w-20 align-middle">TTD</th>
                </tr>
                <tr class="text-black border-b border-black font-bold text-center">
                    <th class="border border-black py-1 px-2 text-center w-20 align-middle">Sebelum</th>
                    <th class="border border-black py-1 px-2 text-center w-20 align-middle">Sesudah</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1: Diisi otomatis jika ada data $loan, atau input manual -->
                <tr>
                    <td class="border border-black py-2 px-2 text-center font-medium h-9">1</td>
                    <td class="border border-black py-2 px-3">
                        <input type="text" value="{{ $loan->item->name ?? '' }}" class="w-full bg-transparent border-0 focus:outline-none text-xs sm:text-sm font-medium" placeholder="">
                    </td>
                    <td class="border border-black py-2 px-2 text-center">
                        <input type="text" value="{{ isset($loan) ? $loan->quantity : '' }}" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder="">
                    </td>
                    <td class="border border-black py-2 px-2 text-center">
                        <input type="text" value="{{ isset($loan) ? 'Baik' : '' }}" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder="">
                    </td>
                    <td class="border border-black py-2 px-2 text-center">
                        <input type="text" value="" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder="">
                    </td>
                    <td class="border border-black py-2 px-2 text-center">
                        <input type="text" value="" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder="">
                    </td>
                    <td class="border border-black py-2 px-2 text-center">
                        <input type="text" value="" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder="">
                    </td>
                </tr>
                <!-- Row 2 -->
                <tr>
                    <td class="border border-black py-2 px-2 text-center font-medium h-9">2</td>
                    <td class="border border-black py-2 px-3"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                </tr>
                <!-- Row 3 -->
                <tr>
                    <td class="border border-black py-2 px-2 text-center font-medium h-9">3</td>
                    <td class="border border-black py-2 px-3"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                </tr>
                <!-- Row 4 -->
                <tr>
                    <td class="border border-black py-2 px-2 text-center font-medium h-9">4</td>
                    <td class="border border-black py-2 px-3"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                </tr>
                <!-- Row 5 -->
                <tr>
                    <td class="border border-black py-2 px-2 text-center font-medium h-9">5</td>
                    <td class="border border-black py-2 px-3"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                </tr>
                <!-- Row 6 -->
                <tr>
                    <td class="border border-black py-2 px-2 text-center font-medium h-9">6</td>
                    <td class="border border-black py-2 px-3"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                    <td class="border border-black py-2 px-2 text-center"><input type="text" class="w-full bg-transparent border-0 focus:outline-none text-center text-xs sm:text-sm" placeholder=""></td>
                </tr>
            </tbody>
        </table>

        <!-- Detail Peminjam (Nama Peminjam, Kelas/Organisasi, Keperluan) -->
        <div class="mt-5 space-y-1.5 text-xs sm:text-sm">
            <div class="flex items-center">
                <span class="w-36 sm:w-44 font-medium">Nama Peminjam</span>
                <span class="w-4 font-bold">:</span>
                <span class="flex-1 font-semibold">
                    <input type="text" value="{{ $loan->student_name ?? '' }}" class="w-full bg-transparent border-b border-transparent hover:border-black focus:border-black focus:outline-none font-semibold text-xs sm:text-sm" placeholder="">
                </span>
            </div>
            <div class="flex items-center">
                <span class="w-36 sm:w-44 font-medium">Kelas / Organisasi</span>
                <span class="w-4 font-bold">:</span>
                <span class="flex-1">
                    <input type="text" value="{{ isset($loan) ? ($loan->student_class . ($loan->organization ? ' / ' . $loan->organization : '')) : '' }}" class="w-full bg-transparent border-b border-transparent hover:border-black focus:border-black focus:outline-none text-xs sm:text-sm" placeholder="">
                </span>
            </div>
            <div class="flex items-center">
                <span class="w-36 sm:w-44 font-medium">Keperluan</span>
                <span class="w-4 font-bold">:</span>
                <span class="flex-1">
                    <input type="text" value="{{ $loan->purpose ?? '' }}" class="w-full bg-transparent border-b border-transparent hover:border-black focus:border-black focus:outline-none text-xs sm:text-sm" placeholder="">
                </span>
            </div>
        </div>

        <!-- Dates Table (Tgl Peminjaman & Tgl Pengambilan) -->
        <table class="w-full border-collapse border border-black mt-6 text-xs sm:text-sm">
            <thead>
                <tr class="text-black border-b border-black font-bold text-center">
                    <th class="border border-black py-2 px-4 text-center w-1/2">Tgl Peminjaman</th>
                    <th class="border border-black py-2 px-4 text-center w-1/2">Tgl Pengambilan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-black p-4 text-center align-middle h-24 sm:h-28">
                        <input type="text" value="{{ isset($loan) && $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->translatedFormat('d F Y') : '' }}" class="w-full text-center bg-transparent border-0 focus:outline-none font-semibold text-xs sm:text-sm" placeholder="">
                    </td>
                    <td class="border border-black p-4 text-center align-middle h-24 sm:h-28">
                        <input type="text" value="{{ isset($loan) && $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->translatedFormat('d F Y') : '' }}" class="w-full text-center bg-transparent border-0 focus:outline-none font-semibold text-xs sm:text-sm" placeholder="">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Blok Tanda Tangan (Signature Block) -->
        <div class="flex justify-between mt-12 text-black text-xs sm:text-sm">
            <!-- Sisi Kiri: Waka Sarana dan Prasarana -->
            <div class="w-64 flex flex-col justify-between h-36 sm:h-40">
                <div>
                    <p class="font-bold text-black">Waka. Sarana dan Prasarana</p>
                    <p class="text-xs text-black mt-0.5">SMKN 1 Ciomas</p>
                </div>
                <div>
                    <p class="font-bold text-black underline underline-offset-2">Mardiana Palantika, S.Pd</p>
                    <p class="text-xs text-black mt-0.5">NIP. 198207252011012003</p>
                </div>
            </div>

            <!-- Sisi Kanan: Kepala Sekolah -->
            <div class="w-64 flex flex-col justify-between h-36 sm:h-40">
                <div>
                    <p class="font-bold text-black">Kepala</p>
                    <p class="text-xs text-black mt-0.5">SMKN 1 Ciomas</p>
                </div>
                <div>
                    <p class="font-bold text-black underline underline-offset-2">Januar Ashari, M.Pd</p>
                    <p class="text-xs text-black mt-0.5">NIP. 198801302011011001</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
