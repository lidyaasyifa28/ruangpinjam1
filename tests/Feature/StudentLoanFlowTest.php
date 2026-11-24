<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentLoanFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_is_a_showcase_with_ticket_lookup_and_without_a_loan_form_or_table(): void
    {
        $this->createItem();

        $this->get('/')
            ->assertSee('Koleksi Alat Tersedia')
            ->assertSee('Lacak Status Tiket')
            ->assertSee('Frequently Asked Questions (FAQ)')
            ->assertSee('Bagaimana alur meminjam sarana sekolah?')
            ->assertSee('Mengapa saya harus menyimpan Nomor Tiket?')
            ->assertSee('Apa yang terjadi jika saya terlambat mengembalikan barang?')
            ->assertSee('Apakah saya bisa membatalkan pengajuan pinjam?')
            ->assertSee('Proyektor')
            ->assertDontSee('name="student_name"', false)
            ->assertDontSee('<table', false);
    }

    public function test_loan_form_is_standalone_without_a_status_table(): void
    {
        $this->createItem();

        $this->get('/pinjam')
            ->assertSee('name="student_name"', false)
            ->assertDontSee('<table', false);
    }

    public function test_submission_saves_a_pending_loan_and_redirects_to_its_ticket(): void
    {
        $item = $this->createItem();

        $response = $this->post(route('student.loan.store'), [
            'item_id' => $item->id,
            'student_name' => 'Alya Putri',
            'student_class' => 'XI PPLG 1',
            'organization' => 'OSIS',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => '2026-10-07',
            'return_date' => '2026-10-08',
            'purpose' => 'Dokumentasi. Acara. Sekolah. SMKN. Ciomas.',
        ]);

        $loan = Loan::query()->firstOrFail();

        $response->assertRedirect(route('student.pinjam'));
        $response->assertSessionHas('success_loan');
        $this->assertDatabaseHas('loans', [
            'ticket_number' => $loan->ticket_number,
            'status' => 'pending',
        ]);
        $this->get(route('student.ticket.show', ['loan' => $loan->ticket_number]))
            ->assertSee($loan->ticket_number)
            ->assertSee('Menunggu Verifikasi');
    }

    public function test_approved_ticket_displays_the_permit_print_action(): void
    {
        $loan = $this->createLoan($this->createItem(), 'approved');

        $this->get(route('student.ticket.show', ['loan' => $loan->ticket_number]))
            ->assertSee('Cetak Surat Izin')
            ->assertSee(route('student.loan.print', ['ticket_number' => $loan->ticket_number]));
    }

    public function test_ticket_lookup_redirects_to_the_matching_ticket(): void
    {
        $loan = $this->createLoan($this->createItem());

        $this->get(route('student.ticket.lookup', ['ticket_number' => 'rp-abc123']))
            ->assertRedirect(route('student.ticket.show', ['loan' => $loan->ticket_number]));
    }

    public function test_approved_loan_pdf_can_be_downloaded(): void
    {
        $item = $this->createItem();
        $loan = $this->createLoan($item, 'approved');

        $response = $this->get(route('student.loan.download', $loan->ticket_number));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_ticket_shows_yellow_warning_when_return_date_is_today_or_tomorrow(): void
    {
        $item = $this->createItem();
        $loanToday = $this->createLoan($item, 'approved', now()->toDateString(), 'RP-TODAY1');
        $this->get(route('student.ticket.show', ['loan' => $loanToday->ticket_number]))
            ->assertOk()
            ->assertSee('bg-yellow-100')
            ->assertSee('Peringatan: Harap kembalikan sarpras ke ruang admin paling lambat')
            ->assertSee('HARI INI');

        $loanTomorrow = $this->createLoan($item, 'approved', now()->addDay()->toDateString(), 'RP-TOMORROW1');
        $this->get(route('student.ticket.show', ['loan' => $loanTomorrow->ticket_number]))
            ->assertOk()
            ->assertSee('bg-yellow-100')
            ->assertSee('Peringatan: Harap kembalikan sarpras ke ruang admin paling lambat')
            ->assertSee('BESOK');
    }

    public function test_ticket_shows_red_warning_when_return_date_is_overdue(): void
    {
        $item = $this->createItem();
        $loanOverdue = $this->createLoan($item, 'approved', now()->subDays(2)->toDateString(), 'RP-LATE01');

        $this->get(route('student.ticket.show', ['loan' => $loanOverdue->ticket_number]))
            ->assertOk()
            ->assertSee('bg-red-100')
            ->assertSee('border-red-500')
            ->assertSee('TERLAMBAT: Tenggat waktu pengembalian telah lewat. Segera kembalikan barang!');
    }

    public function test_ticket_does_not_show_warning_when_loan_is_returned_or_pending(): void
    {
        $item = $this->createItem();
        $loanReturned = $this->createLoan($item, 'returned', now()->subDays(2)->toDateString(), 'RP-RET01');

        $this->get(route('student.ticket.show', ['loan' => $loanReturned->ticket_number]))
            ->assertOk()
            ->assertDontSee('TERLAMBAT: Tenggat waktu pengembalian telah lewat')
            ->assertDontSee('Peringatan: Harap kembalikan sarpras');

        $loanPending = $this->createLoan($item, 'pending', now()->toDateString(), 'RP-PEND01');

        $this->get(route('student.ticket.show', ['loan' => $loanPending->ticket_number]))
            ->assertOk()
            ->assertDontSee('TERLAMBAT: Tenggat waktu pengembalian telah lewat')
            ->assertDontSee('Peringatan: Harap kembalikan sarpras');
    }

    public function test_unknown_ticket_number_returns_not_found(): void
    {
        $this->get('/tiket/RP-MISSING1')->assertNotFound();
    }

    private function createItem(): Item
    {
        return Item::query()->create([
            'name' => 'Proyektor Epson',
            'category' => 'Audio Visual',
            'stock_total' => 4,
            'stock_available' => 3,
        ]);
    }

    private function createLoan(Item $item, string $status = 'pending', ?string $returnDate = null, string $ticketNumber = 'RP-ABC123'): Loan
    {
        return Loan::query()->create([
            'ticket_number' => $ticketNumber,
            'item_id' => $item->id,
            'student_name' => 'Alya Putri',
            'student_class' => 'XI PPLG 1',
            'organization' => 'OSIS',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => '2026-10-07',
            'return_date' => $returnDate ?? '2026-10-08',
            'purpose' => 'Dokumentasi acara sekolah',
            'status' => $status,
        ]);
    }
}
