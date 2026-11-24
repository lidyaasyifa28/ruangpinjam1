<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyLoansExport;
use App\Models\Item;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.index');
    }

    public function dashboard(Request $request): View
    {
        $search = $request->query('search');

        $query = Loan::with('item')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('student_name', 'like', "%{$search}%");
            });
        }

        $loans = $query->paginate(10)->withQueryString();
        $items = Item::all();

        // Statistik global untuk cards dashboard agar tetap akurat saat paginasi/pencarian aktif
        $totalLoansCount = Loan::count();
        $pendingLoansCount = Loan::where('status', 'pending')->count();
        $activeBorrowedUnits = Loan::where('status', 'approved')->sum('quantity');

        return view('admin.dashboard', [
            'loans' => $loans,
            'data' => $loans, // Alias data agar kompatibel dengan {{ $data->links() }}
            'items' => $items,
            'search' => $search,
            'totalLoansCount' => $totalLoansCount,
            'pendingLoansCount' => $pendingLoansCount,
            'activeBorrowedUnits' => $activeBorrowedUnits,
        ]);
    }

    public function persetujuan(Request $request): View
    {
        $search = $request->query('search');

        $query = Loan::with('item')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('student_name', 'like', "%{$search}%");
            });
        }

        $loans = $query->paginate(10)->withQueryString();

        // Counter statistik global agar tetap akurat saat paginasi/pencarian aktif
        $totalLoansCount = Loan::count();
        $pendingLoansCount = Loan::where('status', 'pending')->count();
        $approvedLoansCount = Loan::where('status', 'approved')->count();
        $returnedLoansCount = Loan::where('status', 'returned')->count();

        return view('admin.persetujuan', compact(
            'loans',
            'search',
            'totalLoansCount',
            'pendingLoansCount',
            'approvedLoansCount',
            'returnedLoansCount'
        ));
    }

    public function inventaris(): View
    {
        $items = Item::query()->orderBy('name')->get();

        return view('admin.inventaris', compact('items'));
    }

    public function approveLoan($id)
    {
        $loan = Loan::with('item')->findOrFail($id);
        $item = $loan->item;

        if ($item->stock_available < $loan->quantity) {
            return back()->with('error', 'Stok tidak mencukupi untuk menyetujui peminjaman ini.');
        }

        $item->stock_available -= $loan->quantity;
        $item->save();

        $loan->status = 'approved';
        $loan->save();

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function rejectLoan(Request $request, $id)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        $loan = Loan::findOrFail($id);

        $loan->status = 'rejected';
        $loan->rejection_reason = $request->rejection_reason;
        $loan->save();

        return back()->with('success', 'Peminjaman telah ditolak.');
    }

    /**
     * Konfirmasi fisik pengembalian barang oleh Admin.
     * Mengubah status transaksi menjadi 'returned' (Selesai) dan mengembalikan stok barang.
     */
    public function markAsReturned($id)
    {
        // 1. Cari data transaksi/tiket peminjaman
        $loan = Loan::with('item')
            ->where('id', $id)
            ->orWhere('ticket_number', $id)
            ->firstOrFail();

        // 2. Hanya jalankan saat Admin mengonfirmasi fisik untuk barang yang berstatus 'approved' (Sedang Dipinjam)
        if ($loan->status === 'approved') {
            DB::transaction(function () use ($loan) {
                // Ubah status transaksi menjadi 'returned' (Selesai)
                $loan->status = 'returned';
                $loan->save();

                // Kembalikan stok barang yang berelasi (+ jumlah pinjam)
                $item = $loan->item;
                if ($item) {
                    $item->stock_available = min($item->stock_total, $item->stock_available + $loan->quantity);
                    $item->save();
                }
            });

            return back()->with('success', 'Konfirmasi pengembalian berhasil! Fisik barang telah diterima dan stok inventaris telah dipulihkan.');
        }

        return back()->with('error', 'Status peminjaman tidak valid untuk konfirmasi pengembalian.');
    }

    /**
     * Alias method untuk kompatibilitas route sebelumnya.
     */
    public function returnLoan($id)
    {
        return $this->markAsReturned($id);
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'stock_total' => 'required|integer|min:1',
        ]);

        Item::create([
            'name' => $request->name,
            'category' => $request->category,
            'stock_total' => $request->stock_total,
            'stock_available' => $request->stock_total,
        ]);

        return back()->with('success', 'Barang baru berhasil ditambahkan.');
    }

    public function laporan(Request $request): View
    {
        $startDate = $request->query('start_date') ?: now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->query('end_date') ?: now()->format('Y-m-d');

        if ($startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $baseQuery = Loan::whereBetween('borrow_date', [$startDate, $endDate]);

        $loans = (clone $baseQuery)
            ->with('item')
            ->latest('borrow_date')
            ->paginate(10)
            ->withQueryString();

        $returnedCount = (clone $baseQuery)
            ->where('status', 'returned')
            ->count();

        $activeCount = (clone $baseQuery)
            ->where('status', 'approved')
            ->count();

        $pendingCount = (clone $baseQuery)
            ->where('status', 'pending')
            ->count();

        $totalLoans = (clone $baseQuery)->count();
        $totalMonthLoans = $totalLoans;

        $startCarbon = Carbon::parse($startDate);
        $endCarbon = Carbon::parse($endDate);

        $periodeText = $startDate === $endDate
            ? $startCarbon->translatedFormat('d M Y')
            : $startCarbon->translatedFormat('d M Y').' - '.$endCarbon->translatedFormat('d M Y');

        return view('admin.laporan', compact(
            'loans',
            'startDate',
            'endDate',
            'periodeText',
            'returnedCount',
            'activeCount',
            'pendingCount',
            'totalLoans',
            'totalMonthLoans'
        ));
    }

    public function exportLaporan(Request $request)
    {
        if (! class_exists(Excel::class)) {
            return back()->with('error', 'Package maatwebsite/excel belum terinstal. Silakan jalankan: composer require maatwebsite/excel');
        }

        $startDate = $request->query('start_date') ?: now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->query('end_date') ?: now()->format('Y-m-d');

        if ($startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $fileName = 'laporan-peminjaman-'.$startDate.'-sd-'.$endDate.'.xlsx';

        return Excel::download(new MonthlyLoansExport($startDate, $endDate), $fileName);
    }
}
