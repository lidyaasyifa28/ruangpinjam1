<?php
    $pathKiri = public_path('images/logo-bogor.png');
    $logoKiri = file_exists($pathKiri) ? 'data:image/png;base64,' . base64_encode(file_get_contents($pathKiri)) : '';

    $pathKanan = public_path('images/logo-smk.png');
    $logoKanan = file_exists($pathKanan) ? 'data:image/png;base64,' . base64_encode(file_get_contents($pathKanan)) : '';

    $renderType = $type ?? 'all';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dokumen Peminjaman - {{ $loan->ticket_number ?? 'SMKN 1 Ciomas' }}</title>
    <style>
        @page {
            size: a4 portrait;
            margin: 1.2cm 1.5cm 1.2cm 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #000000;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-after: always;
            break-after: page;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .kop-table {
            border-bottom: 3px double #000000;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        .border-table th, 
        .border-table td {
            border: 1px solid #000000;
            padding: 4px 6px;
        }
        .border-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-justify { text-align: justify; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }
    </style>
</head>
<body>

@if($renderType === 'all' || $renderType === 'form')
    <!-- ========================================================================= -->
    <!-- HALAMAN 1: FORM PEMINJAMAN BARANG/ RUANG                                  -->
    <!-- ========================================================================= -->
    <div class="halaman-1">
        <!-- KOP SURAT (Pure HTML Table) -->
        <table class="kop-table" width="100%">
            <tr>
                <td width="15%" align="left" style="vertical-align: middle;">
                    @if($logoKiri)
                        <img src="{{ $logoKiri }}" width="80" alt="Logo Daerah">
                    @endif
                </td>
                <td width="70%" align="center" style="vertical-align: middle; text-align: center; line-height: 1.25;">
                    <div style="font-size: 11pt; font-weight: bold; text-transform: uppercase;">PEMERINTAH DAERAH PROVINSI JAWA BARAT</div>
                    <div style="font-size: 15pt; font-weight: bold; text-transform: uppercase; margin: 2px 0;">SMK NEGERI 1 CIOMAS</div>
                    <div style="font-size: 8pt;">
                        Jl. Raya Laladon, Ds. Laladon, Kecamatan Ciomas, Kabupaten Bogor<br>
                        Bogor – Jawa Barat 16610; Telpon (0251) 7520933<br>
                        e-mail : smkn1_ciomas@yahoo.co.id; web : www.smkn1ciomas.sch.id
                    </div>
                </td>
                <td width="15%" align="right" style="vertical-align: middle; text-align: right;">
                    @if($logoKanan)
                        <img src="{{ $logoKanan }}" width="80" alt="Logo SMKN 1 Ciomas">
                    @endif
                </td>
            </tr>
        </table>

        <!-- Judul & Nomor Form -->
        <div style="margin-top: 8px; margin-bottom: 10px;">
            <div class="bold underline" style="font-size: 11pt;">Form Peminjaman Barang/ Ruang</div>
            <div style="font-size: 9.5pt; margin-top: 3px;">
                Nomor : <span style="font-family: monospace; font-weight: bold;">{{ $loan->ticket_number ?? '..........' }}</span> /Peminjaman/Sarpras / {{ date('m') }} / {{ date('Y') }}
            </div>
        </div>

        <!-- Tabel Barang / Ruang -->
        <table class="border-table" width="100%" style="font-size: 9pt;">
            <thead>
                <tr>
                    <th rowspan="2" width="5%" style="vertical-align: middle;">No</th>
                    <th rowspan="2" width="37%" style="vertical-align: middle;">Nama Barang / Ruang</th>
                    <th rowspan="2" width="10%" style="vertical-align: middle;">QTY</th>
                    <th colspan="2" width="24%" style="vertical-align: middle;">Kondisi</th>
                    <th rowspan="2" width="14%" style="vertical-align: middle;">Koordinasi</th>
                    <th rowspan="2" width="10%" style="vertical-align: middle;">TTD</th>
                </tr>
                <tr>
                    <th width="12%">Sebelum</th>
                    <th width="12%">Sesudah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" style="height: 22px;">1</td>
                    <td class="bold">{{ $loan->item->name ?? '-' }}</td>
                    <td class="text-center bold">{{ $loan->quantity ?? 1 }}</td>
                    <td class="text-center">Baik</td>
                    <td class="text-center"></td>
                    <td class="text-center">Sarpras</td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">2</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">3</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">4</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">5</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">6</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
            </tbody>
        </table>

        <!-- Detail Peminjam (Table) -->
        <table width="100%" style="margin-top: 10px; font-size: 9.5pt;">
            <tr>
                <td width="22%" style="padding: 2px 0;">Nama Peminjam</td>
                <td width="3%">:</td>
                <td width="75%" class="bold">{{ $loan->student_name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Kelas / Organisasi</td>
                <td>:</td>
                <td>{{ $loan->student_class ?? '-' }}{{ $loan->organization ? ' / ' . $loan->organization : '' }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Keperluan</td>
                <td>:</td>
                <td>{{ $loan->purpose ?? '-' }}</td>
            </tr>
        </table>

        <!-- Tabel Tanggal -->
        <table class="border-table" width="100%" style="margin-top: 10px; font-size: 9.5pt;">
            <thead>
                <tr>
                    <th width="50%" class="text-center">Tgl Peminjaman</th>
                    <th width="50%" class="text-center">Tgl Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center bold" style="height: 48px; vertical-align: middle;">
                        {{ $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td class="text-center bold" style="height: 48px; vertical-align: middle;">
                        {{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Blok Tanda Tangan (Pure HTML Table) -->
        <table width="100%" style="margin-top: 25px; font-size: 9.5pt;">
            <tr>
                <td width="50%" align="left" style="vertical-align: top;">
                    <div class="bold">Waka. Sarana dan Prasarana</div>
                    <div style="font-size: 8.5pt;">SMKN 1 Ciomas</div>
                    <div style="height: 60px;"></div>
                    <div class="bold underline">Mardiana Palantika, S.Pd</div>
                    <div style="font-size: 8.5pt;">NIP. 198207252011012003</div>
                </td>
                <td width="50%" align="right" style="vertical-align: top; text-align: right;">
                    <div style="display: inline-block; text-align: left;">
                        <div class="bold">Kepala Sekolah</div>
                        <div style="font-size: 8.5pt;">SMKN 1 Ciomas</div>
                        <div style="height: 60px;"></div>
                        <div class="bold underline">Januar Ashari, M.Pd</div>
                        <div style="font-size: 8.5pt;">NIP. 198801302011011001</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
@endif

@if($renderType === 'all')
    <!-- Pemisah Halaman untuk DomPDF -->
    <div class="page-break"></div>
@endif

@if($renderType === 'all' || $renderType === 'berita_acara')
    <!-- ========================================================================= -->
    <!-- HALAMAN 2: BERITA ACARA SERAH TERIMA BARANG                               -->
    <!-- ========================================================================= -->
    <div class="halaman-2">
        <!-- KOP SURAT (Pure HTML Table) -->
        <table class="kop-table" width="100%">
            <tr>
                <td width="15%" align="left" style="vertical-align: middle;">
                    @if($logoKiri)
                        <img src="{{ $logoKiri }}" width="80" alt="Logo Daerah">
                    @endif
                </td>
                <td width="70%" align="center" style="vertical-align: middle; text-align: center; line-height: 1.25;">
                    <div style="font-size: 11pt; font-weight: bold; text-transform: uppercase;">PEMERINTAH DAERAH PROVINSI JAWA BARAT</div>
                    <div style="font-size: 15pt; font-weight: bold; text-transform: uppercase; margin: 2px 0;">SMK NEGERI 1 CIOMAS</div>
                    <div style="font-size: 8pt;">
                        Jl. Raya Laladon, Ds. Laladon, Kecamatan Ciomas, Kabupaten Bogor<br>
                        Bogor – Jawa Barat 16610; Telpon (0251) 7520933<br>
                        e-mail : smkn1_ciomas@yahoo.co.id; web : www.smkn1ciomas.sch.id
                    </div>
                </td>
                <td width="15%" align="right" style="vertical-align: middle; text-align: right;">
                    @if($logoKanan)
                        <img src="{{ $logoKanan }}" width="80" alt="Logo SMKN 1 Ciomas">
                    @endif
                </td>
            </tr>
        </table>

        <!-- Judul & Nomor Berita Acara -->
        <div class="text-center" style="margin-top: 8px; margin-bottom: 12px;">
            <div class="bold uppercase" style="font-size: 11pt; letter-spacing: 0.5px;">
                BERITA ACARA SERAH TERIMA BARANG
            </div>
            <div style="font-size: 9.5pt; margin-top: 2px;">
                Nomor : <span style="font-family: monospace; font-weight: bold;">{{ $loan->ticket_number ?? '......' }}</span> /Berita/Sarpras / {{ date('m') }} / {{ date('Y') }}
            </div>
        </div>

        <!-- Paragraf Pembuka -->
        <p class="text-justify" style="font-size: 9.5pt; margin-bottom: 8px;">
            Pada hari ini, <span class="bold">{{ $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->translatedFormat('l, d F Y') : '..............................' }}</span>, kami yang bertanda tangan di bawah ini:
        </p>

        <!-- Pihak Pertama & Kedua (Pure HTML Table) -->
        <div style="margin-left: 10px; font-size: 9.5pt;">
            <div class="bold" style="margin-bottom: 2px;">PIHAK PERTAMA</div>
            <table width="100%" style="margin-left: 15px; margin-bottom: 6px;">
                <tr>
                    <td width="16%">Nama</td>
                    <td width="3%">:</td>
                    <td width="81%" class="bold">Mardiana Palantika, S.Pd</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Wakil Kepala Sekolah Bidang Sarana dan Prasarana</td>
                </tr>
                <tr>
                    <td>Instansi</td>
                    <td>:</td>
                    <td>SMK Negeri 1 Ciomas</td>
                </tr>
            </table>

            <div class="bold" style="margin-bottom: 2px;">PIHAK KEDUA</div>
            <table width="100%" style="margin-left: 15px; margin-bottom: 6px;">
                <tr>
                    <td width="16%">Nama</td>
                    <td width="3%">:</td>
                    <td width="81%" class="bold">{{ $loan->student_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Peminjam / {{ $loan->student_class ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Instansi</td>
                    <td>:</td>
                    <td>{{ $loan->organization ?? 'SMK Negeri 1 Ciomas' }}</td>
                </tr>
            </table>
        </div>

        <!-- Pernyataan 1 -->
        <p class="text-justify" style="font-size: 9.5pt; margin-top: 6px; margin-bottom: 8px;">
            Dengan ini menyatakan bahwa pihak pertama telah menyerahkan barang kepada pihak kedua, dan pihak kedua telah menerima barang dari pihak pertama, berupa:
        </p>

        <!-- Tabel Barang (5 Baris) -->
        <table class="border-table" width="100%" style="font-size: 9pt; margin-bottom: 8px;">
            <thead>
                <tr>
                    <th width="6%">No</th>
                    <th width="42%" class="text-left">Nama Barang</th>
                    <th width="14%">QTY</th>
                    <th width="16%">Kondisi</th>
                    <th width="22%" class="text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" style="height: 22px;">1</td>
                    <td class="bold">{{ $loan->item->name ?? '-' }}</td>
                    <td class="text-center bold">{{ $loan->quantity ?? 1 }} Unit</td>
                    <td class="text-center">Baik</td>
                    <td>{{ $loan->purpose ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">2</td>
                    <td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">3</td>
                    <td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">4</td>
                    <td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td class="text-center" style="height: 22px;">5</td>
                    <td></td><td></td><td></td><td></td>
                </tr>
            </tbody>
        </table>

        <!-- Pernyataan 2 & Penutup -->
        <p class="text-justify" style="font-size: 9pt; margin-bottom: 4px;">
            Barang tersebut diserahkan dalam keadaan baik dan berfungsi dengan normal. Sejak ditandatanganinya berita acara ini, tanggung jawab pemeliharaan dan penggunaan barang sepenuhnya menjadi tanggung jawab pihak kedua sesuai ketentuan yang berlaku.
        </p>
        <p class="text-justify" style="font-size: 9pt; margin-bottom: 12px;">
            Demikian berita acara serah terima barang ini dibuat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya.
        </p>

        <!-- Blok Tanda Tangan (Pure HTML Table) -->
        <table width="100%" style="margin-top: 15px; font-size: 9.5pt;">
            <tr>
                <td width="50%" align="left" style="vertical-align: top;">
                    <div style="height: 14px;"></div>
                    <div class="bold">PIHAK PERTAMA</div>
                    <div style="font-size: 8.5pt;">Wakil Kepala Sekolah</div>
                    <div style="font-size: 8.5pt;">Bidang Sarana dan Prasarana</div>
                    <div style="height: 55px;"></div>
                    <div class="bold underline">Mardiana Palantika, S.Pd</div>
                    <div style="font-size: 8.5pt;">NIP. 198207252011012003</div>
                </td>
                <td width="50%" align="right" style="vertical-align: top; text-align: right;">
                    <div style="display: inline-block; text-align: left; min-width: 200px;">
                        <div style="font-size: 9pt;">
                            Ciomas, {{ $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->translatedFormat('d F Y') : '..............................' }}
                        </div>
                        <div class="bold" style="margin-top: 2px;">PIHAK KEDUA</div>
                        <div style="font-size: 8.5pt;">
                            {{ $loan->student_class ?? '' }}{{ $loan->organization ? ' / ' . $loan->organization : '' }}
                        </div>
                        <div style="height: 55px;"></div>
                        <div class="bold underline">
                            {{ $loan->student_name ?? '...................................................' }}
                        </div>
                        <div style="font-size: 8.5pt;">
                            {{ $loan->student_class ?? '' }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
@endif

</body>
</html>
