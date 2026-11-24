<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    /**
     * Menampilkan daftar semua pertanyaan di forum.
     */
    public function index(): View
    {
        $forums = Forum::query()->latest()->get();

        return view('forum', compact('forums'));
    }

    /**
     * Menyimpan pertanyaan baru yang dikirim oleh siswa.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pengirim' => ['required', 'string', 'max:100'],
            'isi_pertanyaan' => ['required', 'string', 'max:2000'],
        ], [
            'nama_pengirim.required' => 'Nama pengirim wajib diisi.',
            'nama_pengirim.max' => 'Nama pengirim maksimal 100 karakter.',
            'isi_pertanyaan.required' => 'Isi pertanyaan wajib diisi.',
            'isi_pertanyaan.max' => 'Isi pertanyaan maksimal 2000 karakter.',
        ]);

        Forum::create([
            'nama_pengirim' => $validated['nama_pengirim'],
            'isi_pertanyaan' => $validated['isi_pertanyaan'],
        ]);

        return redirect()->route('forum.index')->with('success', 'Pertanyaan Anda berhasil dikirim! Mohon tunggu tanggapan dari petugas sarpras.');
    }
}
