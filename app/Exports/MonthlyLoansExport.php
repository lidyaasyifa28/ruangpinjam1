<?php

namespace App\Exports;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlyLoansExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        public ?string $startDate = null,
        public ?string $endDate = null
    ) {
        $this->startDate = $this->startDate ?: now()->startOfMonth()->format('Y-m-d');
        $this->endDate = $this->endDate ?: now()->format('Y-m-d');

        if ($this->startDate > $this->endDate) {
            [$this->startDate, $this->endDate] = [$this->endDate, $this->startDate];
        }
    }

    /**
     * Mengambil data peminjaman yang berstatus Selesai/Dikembalikan pada rentang tanggal
     */
    public function collection(): Collection
    {
        return Loan::with('item')
            ->where('status', 'returned')
            ->whereBetween('borrow_date', [$this->startDate, $this->endDate])
            ->latest('borrow_date')
            ->get();
    }

    /**
     * Header kolom di file Excel
     */
    public function headings(): array
    {
        return [
            'No. Tiket',
            'Nama Peminjam',
            'Kelas',
            'Organisasi / Ekskul',
            'No. WhatsApp',
            'Nama Sarana / Barang',
            'Jumlah (Unit)',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Keperluan',
            'Status',
        ];
    }

    /**
     * Pemetaan data per baris
     *
     * @param  Loan  $loan
     */
    public function map($loan): array
    {
        return [
            $loan->ticket_number,
            $loan->student_name,
            $loan->student_class,
            $loan->organization,
            $loan->whatsapp,
            $loan->item->name ?? '-',
            $loan->quantity,
            $loan->borrow_date ? Carbon::parse($loan->borrow_date)->format('d/m/Y') : '-',
            $loan->return_date ? Carbon::parse($loan->return_date)->format('d/m/Y') : '-',
            $loan->purpose,
            'Selesai / Dikembalikan',
        ];
    }

    /**
     * Styling baris header Excel (Hijau dengan teks putih tebal)
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '16A34A'], // Green-600
                ],
            ],
        ];
    }
}
