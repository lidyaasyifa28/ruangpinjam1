<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Serah Terima Barang - SMK Negeri 1 Ciomas</title>
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
<body class="bg-slate-100 py-6 sm:py-10 text-slate-900 antialiased min-h-screen">

    <!-- Top Action Bar (No Print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <a href="{{ url()->previous() ?? route('student.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-md transition-colors shadow-sm">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>

        <div class="flex items-center gap-4">
            <span class="text-xs text-slate-500 hidden sm:inline">Format Resmi Dokumen A4 Fisik (Form 2)</span>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak (Ctrl+P)</span>
            </button>
            <a href="{{ route('student.loan.download', ['ticket_number' => $loan->ticket_number, 'type' => 'berita_acara']) }}" download class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Download PDF</span>
            </a>
        </div>
    </div>

    <!-- Container: A4 Paper Style -->
    <div class="a4-container max-w-4xl mx-auto bg-white p-8 md:p-12 shadow border border-slate-200 text-slate-900 text-sm md:text-base leading-normal">
        
        <!-- Header (KOP Resmi Sekolah) -->
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
        <div class="text-center my-5">
            <h1 class="text-base sm:text-lg font-bold uppercase tracking-wide text-slate-950 leading-tight">
                <span class="sr-only">BERITA ACARA SERAH TERIMA BARANG</span>
                <span>BERITA ACARA</span><br>
                <span>SERAH TERIMA BARANG</span>
            </h1>
            <p class="text-xs sm:text-sm font-medium mt-1 text-slate-800">
                Nomor &nbsp; : &nbsp; <input type="text" value="{{ isset($loan) ? $loan->ticket_number : '' }}" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none font-mono text-center w-28 text-xs sm:text-sm" placeholder="......"> /Berita/Sarpras / <input type="text" value="{{ date('m') }}" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none text-center w-10 text-xs sm:text-sm" placeholder=".."> /2026
            </p>
        </div>

        <!-- Paragraf Pembuka -->
        <p class="mt-6 text-justify leading-relaxed">
            Pada hari ini, <input type="text" value="{{ isset($loan) && $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->translatedFormat('l, d F Y') : '' }}" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none min-w-[260px] font-medium" placeholder="............................................">, kami yang bertanda tangan di bawah ini:
        </p>

        <!-- Pihak Terkait (PIHAK PERTAMA & PIHAK KEDUA) -->
        <div class="mt-4 space-y-4">
            
            <!-- PIHAK PERTAMA -->
            <div>
                <div class="font-bold text-slate-950">PIHAK PERTAMA</div>
                <table class="w-full text-xs sm:text-sm ml-4 mt-1 border-0">
                    <tbody>
                        <tr>
                            <td class="w-28 py-0.5 font-medium border-0">Nama</td>
                            <td class="w-4 py-0.5 border-0">:</td>
                            <td class="py-0.5 font-semibold border-0">
                                <input type="text" value="Mardiana Palantika, S.Pd" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none w-full max-w-md font-semibold" placeholder="................................................................">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-0.5 font-medium border-0">Jabatan</td>
                            <td class="py-0.5 border-0">:</td>
                            <td class="py-0.5 border-0">
                                <input type="text" value="Wakil Kepala Sekolah Bidang Sarana dan Prasarana" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none w-full max-w-md" placeholder="................................................................">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-0.5 font-medium border-0">Instansi</td>
                            <td class="py-0.5 border-0">:</td>
                            <td class="py-0.5 border-0">
                                <input type="text" value="SMK Negeri 1 Ciomas" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none w-full max-w-md" placeholder="................................................................">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PIHAK KEDUA -->
            <div>
                <div class="font-bold text-slate-950">PIHAK KEDUA</div>
                <table class="w-full text-xs sm:text-sm ml-4 mt-1 border-0">
                    <tbody>
                        <tr>
                            <td class="w-28 py-0.5 font-medium border-0">Nama</td>
                            <td class="w-4 py-0.5 border-0">:</td>
                            <td class="py-0.5 border-0">
                                <input type="text" value="{{ $loan->student_name ?? '' }}" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none w-full max-w-md font-medium" placeholder="................................................................">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-0.5 font-medium border-0">Jabatan</td>
                            <td class="py-0.5 border-0">:</td>
                            <td class="py-0.5 border-0">
                                <input type="text" value="{{ isset($loan) ? 'Peminjam / ' . $loan->student_class : '' }}" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none w-full max-w-md" placeholder="................................................................">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-0.5 font-medium border-0">Instansi</td>
                            <td class="py-0.5 border-0">:</td>
                            <td class="py-0.5 border-0">
                                <input type="text" value="{{ isset($loan) ? ($loan->organization ?? 'SMK Negeri 1 Ciomas') : 'SMK Negeri 1 Ciomas' }}" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none w-full max-w-md" placeholder="................................................................">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pernyataan 1 -->
        <p class="mt-5 text-justify leading-relaxed">
            Dengan ini menyatakan bahwa pihak pertama telah menyerahkan barang kepada pihak kedua, dan pihak kedua telah menerima barang dari pihak pertama, berupa:
        </p>

        <!-- Tabel Barang (Sharp Corners, Formal Border, 5 Baris Sesuai Dokumen Fisik) -->
        <table class="w-full border-collapse border border-slate-800 mt-4 mb-4 text-xs sm:text-sm">
            <thead>
                <tr class="bg-slate-100 text-slate-950 border-b border-slate-800 font-bold text-center">
                    <th class="border border-slate-800 py-2 px-3 w-12 text-center">No</th>
                    <th class="border border-slate-800 py-2 px-4 text-left">Nama Barang</th>
                    <th class="border border-slate-800 py-2 px-3 w-24 text-center">QTY</th>
                    <th class="border border-slate-800 py-2 px-3 w-28 text-center">Kondisi</th>
                    <th class="border border-slate-800 py-2 px-4 text-left">Ket.</th>
                </tr>
            </thead>
            <tbody>
                <!-- Baris 1: Diisi data otomatis jika ada $loan -->
                <tr>
                    <td class="border border-slate-800 py-2.5 px-3 text-center font-medium">1</td>
                    <td class="border border-slate-800 py-2.5 px-4 font-medium">
                        <input type="text" value="{{ $loan->item->name ?? '' }}" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full" placeholder="....................................................">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="{{ isset($loan) ? $loan->quantity . ' Unit' : '' }}" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="{{ isset($loan) ? 'Baik' : '' }}" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="Baik">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-4">
                        <input type="text" value="{{ $loan->purpose ?? '' }}" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full text-xs" placeholder="....................................................">
                    </td>
                </tr>
                <!-- Baris 2 -->
                <tr>
                    <td class="border border-slate-800 py-2.5 px-3 text-center font-medium">2</td>
                    <td class="border border-slate-800 py-2.5 px-4 font-medium">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full" placeholder="....................................................">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-4">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full text-xs" placeholder="....................................................">
                    </td>
                </tr>
                <!-- Baris 3 -->
                <tr>
                    <td class="border border-slate-800 py-2.5 px-3 text-center font-medium">3</td>
                    <td class="border border-slate-800 py-2.5 px-4 font-medium">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full" placeholder="....................................................">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-4">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full text-xs" placeholder="....................................................">
                    </td>
                </tr>
                <!-- Baris 4 -->
                <tr>
                    <td class="border border-slate-800 py-2.5 px-3 text-center font-medium">4</td>
                    <td class="border border-slate-800 py-2.5 px-4 font-medium">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full" placeholder="....................................................">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-4">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full text-xs" placeholder="....................................................">
                    </td>
                </tr>
                <!-- Baris 5 -->
                <tr>
                    <td class="border border-slate-800 py-2.5 px-3 text-center font-medium">5</td>
                    <td class="border border-slate-800 py-2.5 px-4 font-medium">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full" placeholder="....................................................">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-3 text-center">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none text-center w-full" placeholder="......">
                    </td>
                    <td class="border border-slate-800 py-2.5 px-4">
                        <input type="text" value="" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full text-xs" placeholder="....................................................">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pernyataan 2 -->
        <p class="mt-4 text-justify leading-relaxed">
            Barang tersebut diserahkan dalam keadaan baik dan berfungsi dengan normal. Sejak ditandatanganinya berita acara ini, tanggung jawab pemeliharaan dan penggunaan barang sepenuhnya menjadi tanggung jawab pihak kedua sesuai ketentuan yang berlaku.
        </p>

        <!-- Kalimat Penutup -->
        <p class="mt-3 text-justify leading-relaxed">
            Demikian berita acara serah terima barang ini dibuat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya.
        </p>

        <!-- Blok Tanda Tangan (Signature Block) -->
        <div class="flex justify-between mt-12 text-black text-xs sm:text-sm">
            <!-- Kolom Kiri: PIHAK PERTAMA -->
            <div class="w-72 flex flex-col justify-between h-44">
                <div>
                    <div class="h-5"></div>
                    <p class="font-bold text-slate-950">PIHAK PERTAMA</p>
                    <p class="text-xs text-slate-800">Wakil Kepala Sekolah</p>
                    <p class="text-xs text-slate-800">Bidang Sarana dan Prasarana</p>
                </div>
                <div>
                    <p class="font-bold text-slate-950 underline underline-offset-2">Mardiana Palantika, S.Pd</p>
                    <p class="text-xs text-slate-800 mt-0.5">NIP. 198207252011012003</p>
                </div>
            </div>

            <!-- Kolom Kanan: PIHAK KEDUA -->
            <div class="w-72 flex flex-col justify-between h-44">
                <div>
                    <p class="text-xs sm:text-sm">
                        Ciomas, <input type="text" value="{{ isset($loan) && $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->translatedFormat('d F Y') : '' }}" class="border-b border-slate-800 bg-transparent px-1 focus:outline-none text-center min-w-[150px]" placeholder="..............................">
                    </p>
                    <p class="font-bold text-slate-950 mt-1">PIHAK KEDUA</p>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">
                        {{ isset($loan) ? ($loan->student_class . ($loan->organization ? ' / ' . $loan->organization : '')) : '......................................' }}
                    </p>
                </div>
                <div>
                    <p class="font-bold text-slate-950 underline underline-offset-2">
                        <input type="text" value="{{ $loan->student_name ?? '' }}" class="border-b border-transparent hover:border-slate-400 focus:border-slate-800 bg-transparent px-1 focus:outline-none w-full font-bold" placeholder="...................................................">
                    </p>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">
                        {{ isset($loan) ? ($loan->student_class ?? '') : '...................................................' }}
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
