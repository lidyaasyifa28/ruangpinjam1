<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $items = Item::query()->latest()->get();

        return view('student.landing', compact('items'));
    }

    public function katalog(): View
    {
        $items = Item::query()->orderBy('name')->get();

        return view('student.katalog', compact('items'));
    }

    public function pinjam(Request $request): View
    {
        $items = Item::query()->orderBy('name')->get();
        $selectedItemId = $request->query('item_id', old('item_id'));
        $recentLoans = Loan::with('item')->latest()->take(6)->get();

        $activeLoan = session('success_loan') ?? session('loan');
        if (is_array($activeLoan)) {
            $ticket = $activeLoan['ticket_number'] ?? null;
            $id = $activeLoan['id'] ?? null;
            $activeLoan = $ticket
                ? Loan::with('item')->where('ticket_number', $ticket)->first()
                : ($id ? Loan::with('item')->find($id) : null);
        } elseif (is_string($activeLoan) || is_numeric($activeLoan)) {
            $activeLoan = Loan::with('item')
                ->where('ticket_number', (string) $activeLoan)
                ->orWhere('id', $activeLoan)
                ->first();
        } elseif ($activeLoan instanceof Loan) {
            $activeLoan->loadMissing('item');
        }

        return view('student.pinjam', compact('items', 'selectedItemId', 'recentLoans', 'activeLoan'));
    }

    public function lookupTicket(Request $request): RedirectResponse
    {
        $request->merge([
            'ticket_number' => Str::upper(trim($request->string('ticket_number')->toString())),
        ]);

        $validated = $request->validate([
            'ticket_number' => ['required', 'string', 'exists:loans,ticket_number'],
        ]);

        return redirect()->route('student.ticket.show', ['loan' => $validated['ticket_number']]);
    }

    public function showTicket(Loan $loan): View
    {
        $loan->load('item');

        return view('student.tiket', compact('loan'));
    }

    public function storeLoan(Request $request): RedirectResponse
    {
        if (! $request->filled('nama_peminjam') && $request->filled('student_name')) {
            $request->merge(['nama_peminjam' => $request->input('student_name')]);
        }
        if (! $request->filled('student_name') && $request->filled('nama_peminjam')) {
            $request->merge(['student_name' => $request->input('nama_peminjam')]);
        }
        if (! $request->filled('keperluan') && $request->filled('purpose')) {
            $request->merge(['keperluan' => $request->input('purpose')]);
        }
        if (! $request->filled('purpose') && $request->filled('keperluan')) {
            $request->merge(['purpose' => $request->input('keperluan')]);
        }
        if (! $request->filled('student_class') && $request->filled('kelas_organisasi')) {
            $request->merge(['student_class' => $request->input('kelas_organisasi')]);
        }
        if (! $request->filled('organization') && $request->filled('kelas_organisasi')) {
            $request->merge(['organization' => $request->input('kelas_organisasi')]);
        }
        if (! $request->filled('borrow_date') && $request->filled('tgl_peminjaman')) {
            $request->merge(['borrow_date' => $request->input('tgl_peminjaman')]);
        }
        if (! $request->filled('return_date') && $request->filled('tgl_pengambilan')) {
            $request->merge(['return_date' => $request->input('tgl_pengambilan')]);
        }

        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'nama_peminjam' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\.\']+(?:\s+[a-zA-Z\.\']+)+$/',
            ],
            'student_name' => [
                'sometimes',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\.\']+(?:\s+[a-zA-Z\.\']+)+$/',
            ],
            'student_class' => 'required|string|max:50',
            'organization' => 'required|string|max:100',
            'whatsapp' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'keperluan' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (str_word_count((string) $value) < 5) {
                        $fail('Alasan keperluan harus dijelaskan minimal 5 kata.');
                    }
                },
            ],
            'purpose' => [
                'sometimes',
                'string',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (str_word_count((string) $value) < 5) {
                        $fail('Alasan keperluan harus dijelaskan minimal 5 kata.');
                    }
                },
            ],
        ], [
            'nama_peminjam.required' => 'Nama peminjam wajib diisi.',
            'nama_peminjam.regex' => 'Harap masukkan nama lengkap Anda (minimal 2 kata).',
            'student_name.required' => 'Nama peminjam wajib diisi.',
            'student_name.regex' => 'Harap masukkan nama lengkap Anda (minimal 2 kata).',
            'keperluan.required' => 'Keperluan peminjaman wajib diisi.',
            'purpose.required' => 'Keperluan peminjaman wajib diisi.',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($validated['quantity'] > $item->stock_available) {
            return back()->with('error', 'Jumlah pinjam melebihi stok yang tersedia saat ini.');
        }

        $ticket = 'RP-'.strtoupper(Str::random(6));

        $loan = Loan::create([
            'ticket_number' => $ticket,
            'item_id' => $item->id,
            'student_name' => $validated['nama_peminjam'] ?? $validated['student_name'],
            'student_class' => $validated['student_class'],
            'organization' => $validated['organization'],
            'whatsapp' => $validated['whatsapp'],
            'quantity' => $validated['quantity'],
            'borrow_date' => $validated['borrow_date'],
            'return_date' => $validated['return_date'],
            'purpose' => $validated['keperluan'] ?? $validated['purpose'],
            'status' => 'pending',
        ]);

        $loan->load('item');

        return redirect()->route('student.pinjam')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim! Simpan nomor tiket untuk melacak statusnya.')
            ->with('success_loan', $loan->ticket_number)
            ->with('loan', $loan);
    }

    public function printPermit(string $ticket_number): View|RedirectResponse
    {
        $loan = Loan::with('item')->where('ticket_number', $ticket_number)->firstOrFail();

        if ($loan->status !== 'approved' && $loan->status !== 'returned') {
            return redirect()->route('student.ticket.show', ['loan' => $loan->ticket_number])
                ->with('error', 'Surat peminjaman hanya dapat dicetak setelah disetujui pengelola.');
        }

        return view('student.print', compact('loan'));
    }

    public function downloadPdf(string $ticket_number, Request $request)
    {
        $loan = Loan::with('item')
            ->where('ticket_number', $ticket_number)
            ->orWhere('id', $ticket_number)
            ->firstOrFail();

        if ($loan->status !== 'approved' && $loan->status !== 'returned') {
            return redirect()->route('student.ticket.show', ['loan' => $loan->ticket_number])
                ->with('error', 'Surat peminjaman hanya dapat diunduh setelah disetujui pengelola.');
        }

        if (! class_exists(Pdf::class)) {
            return back()->with('error', 'Package barryvdh/laravel-dompdf belum terinstal. Silakan jalankan di terminal: composer require barryvdh/laravel-dompdf');
        }

        $type = $request->query('type', 'all');

        $filename = match ($type) {
            'form' => 'Form_Peminjaman_SMKN1Ciomas.pdf',
            'berita_acara' => 'Berita_Acara_SMKN1Ciomas.pdf',
            default => 'Form_Peminjaman_SMKN1Ciomas.pdf',
        };

        $pdf = Pdf::loadView('student.cetak-pdf', compact('loan', 'type'))
            ->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }
}
