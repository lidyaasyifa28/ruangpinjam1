<?php

namespace Tests\Feature;

use App\Models\Forum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumTest extends TestCase
{
    use RefreshDatabase;

    public function test_forum_page_can_be_rendered(): void
    {
        $response = $this->get(route('forum.index'));

        $response->assertOk()
            ->assertSee('Papan Diskusi &amp; Pertanyaan', false)
            ->assertSee('Tulis Pertanyaan Baru')
            ->assertSee('Belum Ada Pertanyaan');
    }

    public function test_student_can_submit_a_new_question(): void
    {
        $response = $this->post(route('forum.store'), [
            'nama_pengirim' => 'Rizky Pratama - XI TKJ 1',
            'isi_pertanyaan' => 'Apakah kabel HDMI proyektor sudah tersedia di ruang admin?',
        ]);

        $response->assertRedirect(route('forum.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('forums', [
            'nama_pengirim' => 'Rizky Pratama - XI TKJ 1',
            'isi_pertanyaan' => 'Apakah kabel HDMI proyektor sudah tersedia di ruang admin?',
            'jawaban_admin' => null,
        ]);
    }

    public function test_forum_displays_questions_and_admin_answers(): void
    {
        $answered = Forum::query()->create([
            'nama_pengirim' => 'Dewi Sartika',
            'isi_pertanyaan' => 'Bolehkah meminjam kamera DSLR untuk hari Sabtu?',
            'jawaban_admin' => 'Boleh, selama ada surat izin kegiatan dari pembina OSIS.',
        ]);

        $unanswered = Forum::query()->create([
            'nama_pengirim' => 'Budi Santoso',
            'isi_pertanyaan' => 'Bagaimana jika remote proyektor baterainya habis?',
            'jawaban_admin' => null,
        ]);

        $response = $this->get(route('forum.index'));

        $response->assertOk()
            ->assertSee($answered->nama_pengirim)
            ->assertSee($answered->isi_pertanyaan)
            ->assertSee('Dijawab')
            ->assertSee('Tanggapan Pengelola Sarpras')
            ->assertSee($answered->jawaban_admin)
            ->assertSee($unanswered->nama_pengirim)
            ->assertSee($unanswered->isi_pertanyaan)
            ->assertSee('Menunggu');
    }

    public function test_validation_errors_when_required_fields_are_missing(): void
    {
        $response = $this->post(route('forum.store'), [
            'nama_pengirim' => '',
            'isi_pertanyaan' => '',
        ]);

        $response->assertSessionHasErrors(['nama_pengirim', 'isi_pertanyaan']);
        $this->assertDatabaseCount('forums', 0);
    }
}
