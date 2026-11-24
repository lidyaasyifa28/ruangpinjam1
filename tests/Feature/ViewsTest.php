<?php

namespace Tests\Feature;

use App\Exports\MonthlyLoansExport;
use App\Models\Item;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_successfully(): void
    {
        Item::create([
            'name' => 'Proyektor Epson Test',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 3,
        ]);
        Item::create([
            'name' => 'Kabel Roll Test',
            'category' => 'Kelistrikan',
            'stock_total' => 2,
            'stock_available' => 0,
        ]);

        $response = $this->get(route('student.index'));
        $response->assertStatus(200);
        $response->assertSee('RuangPinjam');
        $response->assertSee('Peminjaman Sarana Sekolah Lebih Cepat');
        $response->assertSee('Peralatan Populer Siap Pakai');
        $response->assertSee('Alur Layanan');
        $response->assertSee('Proyektor Epson Test');
        $response->assertSee('Multimedia');
        $response->assertSee('Tersedia');
        $response->assertSee('Kabel Roll Test');
        $response->assertSee('Kelistrikan');
        $response->assertSee('Habis');
    }

    public function test_katalog_page_renders_successfully(): void
    {
        $response = $this->get(route('student.katalog'));
        $response->assertStatus(200);
        $response->assertSee('Katalog Ketersediaan Sarana');
    }

    public function test_pinjam_page_renders_clean_form_initially(): void
    {
        $response = $this->get(route('student.pinjam'));
        $response->assertStatus(200);
        $response->assertSee('Formulir Peminjaman Alat');
        $response->assertDontSee('Detail Tiket Peminjaman Baru');
    }

    public function test_pinjam_page_shows_ticket_status_when_session_present(): void
    {
        $item = Item::create([
            'name' => 'Proyektor Epson EB-X400',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 5,
        ]);

        $loan = Loan::create([
            'ticket_number' => 'RP-TEST99',
            'item_id' => $item->id,
            'student_name' => 'Budi Santoso',
            'student_class' => 'XI PPLG 1',
            'organization' => 'OSIS',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDays(2)->toDateString(),
            'purpose' => 'Presentasi Proyek Akhir',
            'status' => 'pending',
        ]);
        $loan->load('item');

        $response = $this->withSession(['success_loan' => $loan])->get(route('student.pinjam'));
        $response->assertStatus(200);
        $response->assertSee('Detail Tiket Peminjaman Baru');
        $response->assertSee('RP-TEST99');
        $response->assertSee('Budi Santoso');
    }

    public function test_submitting_loan_redirects_to_pinjam_with_session(): void
    {
        $item = Item::create([
            'name' => 'Kabel Roll 25M',
            'category' => 'Kelistrikan',
            'stock_total' => 10,
            'stock_available' => 10,
        ]);

        $response = $this->post(route('student.loan.store'), [
            'item_id' => $item->id,
            'student_name' => 'Ahmad Dani',
            'student_class' => 'XII TKJ 2',
            'organization' => 'Pramuka',
            'whatsapp' => '08987654321',
            'quantity' => 2,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDay()->toDateString(),
            'purpose' => 'Kegiatan Persami. Acara kepramukaan sekolah. Berkemah di lapangan. Butuh penerangan malam. Pengembalian tepat waktu.',
        ]);

        $response->assertRedirect(route('student.pinjam'));
        $response->assertSessionHas('success_loan');
        $response->assertSessionHas('loan');
    }

    public function test_submitting_loan_and_following_redirect_renders_ticket_detail(): void
    {
        $item = Item::create([
            'name' => 'Kabel Roll 25M',
            'category' => 'Kelistrikan',
            'stock_total' => 10,
            'stock_available' => 10,
        ]);

        $response = $this->post(route('student.loan.store'), [
            'item_id' => $item->id,
            'student_name' => 'Ahmad Dani',
            'student_class' => 'XII TKJ 2',
            'organization' => 'Pramuka',
            'whatsapp' => '08987654321',
            'quantity' => 2,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDay()->toDateString(),
            'purpose' => 'Kegiatan Persami. Acara kepramukaan sekolah. Berkemah di lapangan. Butuh penerangan malam. Pengembalian tepat waktu.',
        ]);

        $followResponse = $this->followRedirects($response);
        $followResponse->assertStatus(200);
        $followResponse->assertSee('Detail Tiket Peminjaman Baru');
        $followResponse->assertSee('Ahmad Dani');
        $followResponse->assertSee('Kegiatan Persami.');
    }

    public function test_pinjam_renders_gracefully_when_session_loan_is_an_array(): void
    {
        $item = Item::create([
            'name' => 'Proyektor Epson EB-X400',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 5,
        ]);

        $loan = Loan::create([
            'ticket_number' => 'RP-ARRTEST',
            'item_id' => $item->id,
            'student_name' => 'Siti Aminah',
            'student_class' => 'XI AKL 1',
            'organization' => 'PMR',
            'whatsapp' => '081122334455',
            'quantity' => 1,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDays(2)->toDateString(),
            'purpose' => 'Latihan Gabungan',
            'status' => 'pending',
        ]);

        $response = $this->withSession([
            'success_loan' => ['ticket_number' => 'RP-ARRTEST'],
        ])->get(route('student.pinjam'));

        $response->assertStatus(200);
        $response->assertSee('RP-ARRTEST');
        $response->assertSee('Siti Aminah');
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertSee('Login Pengelola');
        $response->assertSee('toggle-password');
    }

    public function test_admin_dashboard_renders_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Panel Pengelola Sarpras');
        $response->assertSee('fixed inset-y-0 left-0 z-50 w-64', false);
        $response->assertSee('-translate-x-full md:relative md:translate-x-0', false);
        $response->assertSee('Total Peminjaman');
        $response->assertSee('Menunggu Persetujuan');
        $response->assertSee('Alat Terpinjam');
        $response->assertSee('Total Aset');
        $response->assertSee('Daftar Pengajuan Peminjaman');
        $response->assertSee('Tambah Sarana');

        // Verify root /admin route also works seamlessly
        $this->actingAs($user)->get(route('admin.index'))->assertStatus(200);
    }

    public function test_admin_dashboard_supports_search_and_pagination(): void
    {
        $user = User::factory()->create();
        $item = Item::create([
            'name' => 'Kamera DSLR Canon',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 5,
        ]);

        // Buat 15 data peminjaman untuk menguji pagination (10 per halaman)
        for ($i = 1; $i <= 15; $i++) {
            Loan::create([
                'ticket_number' => sprintf('RP-TIKET%02d', $i),
                'item_id' => $item->id,
                'student_name' => $i === 1 ? 'Ahmad Fauzi Spesifik' : 'Siswa Nomor '.$i,
                'student_class' => 'XII RPL 1',
                'organization' => 'OSIS',
                'whatsapp' => '081234567890',
                'quantity' => 1,
                'borrow_date' => now()->toDateString(),
                'return_date' => now()->addDays(2)->toDateString(),
                'purpose' => 'Kegiatan '.$i,
                'status' => 'pending',
                'created_at' => now()->subMinutes($i),
            ]);
        }

        // Test paginasi default (halaman 1 menampilkan 10 data, dan link pagination)
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('name="search"', false);
        $response->assertSee('RP-TIKET01');
        $response->assertSee('RP-TIKET10');
        $response->assertDontSee('RP-TIKET15'); // Ada di halaman 2

        // Test halaman 2
        $responsePage2 = $this->actingAs($user)->get(route('admin.dashboard', ['page' => 2]));
        $responsePage2->assertStatus(200);
        $responsePage2->assertSee('RP-TIKET15');

        // Test fitur pencarian berdasarkan ticket_number
        $searchTicket = $this->actingAs($user)->get(route('admin.dashboard', ['search' => 'RP-TIKET15']));
        $searchTicket->assertStatus(200);
        $searchTicket->assertSee('RP-TIKET15');
        $searchTicket->assertDontSee('RP-TIKET01');

        // Test fitur pencarian berdasarkan student_name
        $searchName = $this->actingAs($user)->get(route('admin.dashboard', ['search' => 'Fauzi Spesifik']));
        $searchName->assertStatus(200);
        $searchName->assertSee('Ahmad Fauzi Spesifik');
        $searchName->assertDontSee('RP-TIKET02');
    }

    public function test_admin_persetujuan_page_renders_successfully(): void
    {
        $user = User::factory()->create();
        $item = Item::create([
            'name' => 'Mic Wireless Shure',
            'category' => 'Elektronik',
            'stock_total' => 15,
            'stock_available' => 15,
        ]);

        for ($i = 1; $i <= 12; $i++) {
            Loan::create([
                'ticket_number' => sprintf('RP-SETUJU%02d', $i),
                'item_id' => $item->id,
                'student_name' => $i === 1 ? 'Peminjam Unik Persetujuan' : 'Siswa '.$i,
                'student_class' => 'XI TJKT 1',
                'organization' => 'PMR',
                'whatsapp' => '081234567890',
                'quantity' => 1,
                'borrow_date' => now()->toDateString(),
                'return_date' => now()->addDays(2)->toDateString(),
                'purpose' => 'Ujian Praktik '.$i,
                'status' => 'pending',
                'created_at' => now()->subMinutes($i),
            ]);
        }

        $response = $this->actingAs($user)->get(route('admin.persetujuan'));
        $response->assertStatus(200);
        $response->assertSee('w-full max-w-full overflow-x-auto relative bg-white shadow-sm sm:rounded-lg border border-gray-200', false);
        $response->assertSee('w-full text-left whitespace-nowrap', false);
        $response->assertSee('name="search"', false);
        $response->assertSee('RP-SETUJU01');
        $response->assertSee('RP-SETUJU10');
        $response->assertDontSee('RP-SETUJU12'); // Ada di halaman 2
        $response->assertSee('id="antrean-peminjaman"', false);
        $response->assertSee('#antrean-peminjaman', false);
        $response->assertSee('scroll-mt-20', false);

        // Test search
        $searchResponse = $this->actingAs($user)->get(route('admin.persetujuan', ['search' => 'Peminjam Unik']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Peminjam Unik Persetujuan');
        $searchResponse->assertDontSee('RP-SETUJU02');
        $searchResponse->assertSee('#antrean-peminjaman', false);
    }

    public function test_admin_inventaris_page_renders_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.inventaris'));
        $response->assertStatus(200);
        $response->assertSee('Manajemen Inventaris Sarana & Prasarana');
        $response->assertSee('Tambah Sarana & Alat Baru');
        $response->assertSee('Daftar Inventaris Sarpras Terdaftar');
    }

    public function test_admin_laporan_page_renders_successfully(): void
    {
        $user = User::factory()->create();
        $item = Item::create([
            'name' => 'Proyektor BenQ',
            'category' => 'Multimedia',
            'stock_total' => 3,
            'stock_available' => 3,
        ]);

        // Peminjaman bulan ini
        Loan::create([
            'ticket_number' => 'RP-BULANINI',
            'item_id' => $item->id,
            'student_name' => 'Siswa Bulan Ini',
            'student_class' => 'XI RPL 2',
            'organization' => 'PMR',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => now()->startOfMonth()->addDays(2)->toDateString(),
            'return_date' => now()->startOfMonth()->addDays(3)->toDateString(),
            'purpose' => 'Kegiatan Bulan Ini',
            'status' => 'returned',
        ]);

        // Peminjaman 2 bulan lalu (tidak boleh muncul)
        Loan::create([
            'ticket_number' => 'RP-BULANLALU',
            'item_id' => $item->id,
            'student_name' => 'Siswa Masa Lalu',
            'student_class' => 'XII RPL 1',
            'organization' => 'OSIS',
            'whatsapp' => '089876543210',
            'quantity' => 1,
            'borrow_date' => now()->subMonths(2)->toDateString(),
            'return_date' => now()->subMonths(2)->addDays(1)->toDateString(),
            'purpose' => 'Kegiatan Masa Lalu',
            'status' => 'returned',
        ]);

        $response = $this->actingAs($user)->get(route('admin.laporan'));
        $response->assertStatus(200);
        $response->assertSee('Laporan Rekapitulasi Peminjaman');
        $response->assertSee('Daftar Rekapitulasi Peminjaman');
        $response->assertSee('name="start_date"', false);
        $response->assertSee('name="end_date"', false);
        $response->assertSee('Unduh Laporan Excel');
        $response->assertSee('bg-green-600', false);
        $response->assertSee(route('admin.laporan.export'), false);

        // Hanya data bulan ini yang tampil secara default
        $response->assertSee('RP-BULANINI');
        $response->assertSee('Siswa Bulan Ini');
        $response->assertDontSee('RP-BULANLALU');
        $response->assertDontSee('Siswa Masa Lalu');

        // Test filter rentang tanggal kustom (ambil data 2 bulan lalu)
        $pastStartDate = now()->subMonths(2)->startOfMonth()->toDateString();
        $pastEndDate = now()->subMonths(2)->endOfMonth()->toDateString();
        $filteredResponse = $this->actingAs($user)->get(route('admin.laporan', [
            'start_date' => $pastStartDate,
            'end_date' => $pastEndDate,
        ]));
        $filteredResponse->assertStatus(200);
        $filteredResponse->assertSee('RP-BULANLALU');
        $filteredResponse->assertSee('Siswa Masa Lalu');
        $filteredResponse->assertDontSee('RP-BULANINI');
    }

    public function test_pinjam_form_contains_official_input_names(): void
    {
        $response = $this->get(route('student.pinjam'));
        $response->assertStatus(200);
        $response->assertSee('name="nama_peminjam"', false);
        $response->assertSee('title="Harap masukkan nama lengkap (minimal 2 kata)"', false);
        $response->assertSee('pattern="^[a-zA-Z\.\\\']+(?:\s+[a-zA-Z\.\\\']+)+$"', false);
        $response->assertSee('name="kelas_organisasi"', false);
        $response->assertSee('name="tgl_peminjaman"', false);
        $response->assertSee('name="tgl_pengambilan"', false);
        $response->assertSee('name="keperluan"', false);
        $response->assertSee('Harap jelaskan keperluan minimal dalam 5 kata.');
    }

    public function test_loan_submission_rejects_single_word_name(): void
    {
        $item = Item::create([
            'name' => 'Proyektor Epson Test',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 5,
        ]);

        $response = $this->post(route('student.loan.store'), [
            'item_id' => $item->id,
            'nama_peminjam' => 'Budi',
            'student_class' => 'XI PPLG 1',
            'organization' => 'OSIS',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDay()->toDateString(),
            'keperluan' => 'Satu dua tiga empat lima',
        ]);

        $response->assertSessionHasErrors(['nama_peminjam' => 'Harap masukkan nama lengkap Anda (minimal 2 kata).']);
    }

    public function test_loan_submission_rejects_keperluan_with_less_than_five_words(): void
    {
        $item = Item::create([
            'name' => 'Proyektor Epson Test',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 5,
        ]);

        $response = $this->post(route('student.loan.store'), [
            'item_id' => $item->id,
            'nama_peminjam' => 'Budi Santoso',
            'student_class' => 'XI PPLG 1',
            'organization' => 'OSIS',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDay()->toDateString(),
            'keperluan' => 'Untuk keperluan presentasi',
        ]);

        $response->assertSessionHasErrors(['keperluan' => 'Alasan keperluan harus dijelaskan minimal 5 kata.']);
    }

    public function test_loan_submission_accepts_keperluan_with_five_words_without_punctuation(): void
    {
        $item = Item::create([
            'name' => 'Proyektor Epson Test 2',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 5,
        ]);

        $response = $this->post(route('student.loan.store'), [
            'item_id' => $item->id,
            'nama_peminjam' => 'Budi Santoso',
            'student_class' => 'XI PPLG 1',
            'organization' => 'OSIS',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDay()->toDateString(),
            'keperluan' => 'Satu dua tiga empat lima kata',
        ]);

        $response->assertSessionHasNoErrors();
    }

    public function test_berita_acara_renders_with_official_smkn_1_ciomas_template(): void
    {
        $item = Item::create([
            'name' => 'Proyektor Epson EB-X400',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 5,
        ]);

        $loan = Loan::create([
            'ticket_number' => 'RP-BA999',
            'item_id' => $item->id,
            'student_name' => 'Muhammad Rizky',
            'student_class' => 'XII PPLG 2',
            'organization' => 'OSIS',
            'whatsapp' => '081298765432',
            'quantity' => 1,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDay()->toDateString(),
            'purpose' => 'LDKS OSIS SMKN 1 Ciomas',
            'status' => 'approved',
        ]);

        $response = $this->get(route('student.loan.print', ['ticket_number' => $loan->ticket_number]));
        $response->assertStatus(200);
        $response->assertSee('PEMERINTAH DAERAH PROVINSI JAWA BARAT');
        $response->assertSee('SMK NEGERI 1 CIOMAS');
        $response->assertSee('BERITA ACARA SERAH TERIMA BARANG');
        $response->assertSee('Mardiana Palantika, S.Pd');
        $response->assertSee('198207252011012003');
        $response->assertSee('PIHAK PERTAMA');
        $response->assertSee('PIHAK KEDUA');
        $response->assertSee('Muhammad Rizky');
        $response->assertSee('smkn1_ciomas@yahoo.co.id');
        $response->assertSee('Barang tersebut diserahkan dalam keadaan baik dan berfungsi dengan normal.');
        $response->assertSee('Sejak ditandatanganinya berita acara ini, tanggung jawab pemeliharaan dan penggunaan barang sepenuhnya menjadi tanggung jawab pihak kedua');
        $response->assertSee('Demikian berita acara serah terima barang ini dibuat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya.');
        $response->assertSee('Ciomas,');
    }

    public function test_cetak_peminjaman_form_renders_with_official_physical_layout(): void
    {
        $item = Item::create([
            'name' => 'Kamera Canon EOS 3000D',
            'category' => 'Multimedia',
            'stock_total' => 3,
            'stock_available' => 3,
        ]);

        $loan = Loan::create([
            'ticket_number' => 'RP-FORM01',
            'item_id' => $item->id,
            'student_name' => 'Fajar Pratama',
            'student_class' => 'XI DKV 1',
            'organization' => 'Sinematografi',
            'whatsapp' => '081234567899',
            'quantity' => 1,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDay()->toDateString(),
            'purpose' => 'Praktik Pembuatan Video',
            'status' => 'approved',
        ]);

        $response = $this->get(route('student.loan.print', ['ticket_number' => $loan->ticket_number, 'form' => 'peminjaman']));
        $response->assertStatus(200);
        $response->assertSee('Form Peminjaman Barang/ Ruang');
        $response->assertSee('/Peminjaman/Sarpras /');
        $response->assertSee('/2026');
        $response->assertSee('Nama Barang/');
        $response->assertSee('Sebelum');
        $response->assertSee('Sesudah');
        $response->assertSee('Koordinasi');
        $response->assertSee('TTD');
        $response->assertSee('Nama Peminjam');
        $response->assertSee('Kelas / Organisasi');
        $response->assertSee('Keperluan');
        $response->assertSee('Tgl Peminjaman');
        $response->assertSee('Tgl Pengambilan');
        $response->assertSee('Waka. Sarana dan Prasarana');
        $response->assertSee('Mardiana Palantika, S.Pd');
        $response->assertSee('198207252011012003');
        $response->assertSee('Kepala');
        $response->assertSee('Januar Ashari, M.Pd');
        $response->assertSee('198801302011011001');
        $response->assertSee('Fajar Pratama');
        $response->assertSee('Kamera Canon EOS 3000D');
    }

    public function test_admin_manual_return_confirmation_updates_status_and_restores_stock(): void
    {
        $user = User::factory()->create();
        $item = Item::create([
            'name' => 'Tripod Beike',
            'category' => 'Multimedia',
            'stock_total' => 5,
            'stock_available' => 3, // 2 dipinjam
        ]);

        // Peminjaman yang tanggal kembalinya sudah lewat (overdue)
        $loan = Loan::create([
            'ticket_number' => 'RP-MANUAL01',
            'item_id' => $item->id,
            'student_name' => 'Budi Santoso',
            'student_class' => 'XII RPL 2',
            'organization' => 'Sinematografi',
            'whatsapp' => '081234567890',
            'quantity' => 2,
            'borrow_date' => now()->subDays(5)->toDateString(),
            'return_date' => now()->subDays(2)->toDateString(), // Tanggal pengembalian sudah tiba/lewat
            'purpose' => 'Liputan Acara',
            'status' => 'approved', // Status masih 'approved' (Sedang Dipinjam), TIDAK OTOMATIS ready
        ]);

        // Verifikasi sebelum konfirmasi fisik: stok belum bertambah dan status belum selesai
        $item->refresh();
        $this->assertEquals(3, $item->stock_available);
        $this->assertEquals('approved', $loan->status);

        // Admin melakukan konfirmasi fisik barang kembali
        $response = $this->actingAs($user)->patch(route('admin.loan.return', $loan->id));
        $response->assertSessionHas('success');

        // Verifikasi setelah konfirmasi fisik: status menjadi returned dan stok pulih (+2)
        $loan->refresh();
        $item->refresh();
        $this->assertEquals('returned', $loan->status);
        $this->assertEquals(5, $item->stock_available);

        // Jika dipanggil ulang, tidak boleh menambah stok ganda
        $repeatResponse = $this->actingAs($user)->patch(route('admin.loan.return', $loan->id));
        $repeatResponse->assertSessionHas('error');
        $item->refresh();
        $this->assertEquals(5, $item->stock_available);
    }

    public function test_admin_dashboard_and_persetujuan_display_konfirmasi_barang_kembali_button_for_approved_loans(): void
    {
        $user = User::factory()->create();
        $item = Item::create([
            'name' => 'Gimbal Stabilizer DJI',
            'category' => 'Multimedia',
            'stock_total' => 4,
            'stock_available' => 3,
        ]);

        $loan = Loan::create([
            'ticket_number' => 'RP-KEMBALI01',
            'item_id' => $item->id,
            'student_name' => 'Citra Lestari',
            'student_class' => 'XI DKV 1',
            'organization' => 'Jurnalistik',
            'whatsapp' => '081298765432',
            'quantity' => 1,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDays(2)->toDateString(),
            'purpose' => 'Vlog Sekolah',
            'status' => 'approved',
        ]);

        // Cek di halaman persetujuan
        $persetujuanResponse = $this->actingAs($user)->get(route('admin.persetujuan'));
        $persetujuanResponse->assertStatus(200);
        $persetujuanResponse->assertSee('Sedang Dipinjam');
        $persetujuanResponse->assertSee('Konfirmasi Barang Kembali');
        $persetujuanResponse->assertSee('bg-blue-600 hover:bg-blue-700', false);
        $persetujuanResponse->assertSee(route('admin.loan.return', $loan->id), false);

        // Cek di halaman dashboard
        $dashboardResponse = $this->actingAs($user)->get(route('admin.dashboard'));
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Sedang Dipinjam');
        $dashboardResponse->assertSee('Konfirmasi Barang Kembali');
        $dashboardResponse->assertSee('bg-blue-600 hover:bg-blue-700', false);
        $dashboardResponse->assertSee(route('admin.loan.return', $loan->id), false);
    }

    public function test_admin_can_export_laporan_with_date_range(): void
    {
        Excel::fake();

        $user = User::factory()->create();

        $startDate = '2026-10-01';
        $endDate = '2026-10-31';

        $response = $this->actingAs($user)->get(route('admin.laporan.export', [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]));

        $response->assertStatus(200);

        Excel::assertDownloaded('laporan-peminjaman-2026-10-01-sd-2026-10-31.xlsx', function (MonthlyLoansExport $export) use ($startDate, $endDate) {
            return $export->startDate === $startDate && $export->endDate === $endDate;
        });
    }

    public function test_monthly_loans_export_filters_by_custom_date_range(): void
    {
        $item = Item::create([
            'name' => 'Kabel Roll Test',
            'category' => 'Kelistrikan',
            'stock_total' => 2,
            'stock_available' => 2,
        ]);

        Loan::create([
            'ticket_number' => 'RP-EXP01',
            'item_id' => $item->id,
            'student_name' => 'Siswa Oktober',
            'student_class' => 'XI RPL 1',
            'organization' => 'OSIS',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => '2026-10-15',
            'return_date' => '2026-10-16',
            'purpose' => 'Kegiatan',
            'status' => 'returned',
        ]);

        Loan::create([
            'ticket_number' => 'RP-EXP02',
            'item_id' => $item->id,
            'student_name' => 'Siswa November',
            'student_class' => 'XI RPL 1',
            'organization' => 'OSIS',
            'whatsapp' => '081234567890',
            'quantity' => 1,
            'borrow_date' => '2026-11-05',
            'return_date' => '2026-11-06',
            'purpose' => 'Kegiatan',
            'status' => 'returned',
        ]);

        $export = new MonthlyLoansExport('2026-10-01', '2026-10-31');
        $collection = $export->collection();

        $this->assertCount(1, $collection);
        $this->assertEquals('RP-EXP01', $collection->first()->ticket_number);
    }
}
