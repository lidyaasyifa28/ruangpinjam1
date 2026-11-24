<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. Halaman Siswa (Landing, Katalog, Form, & Cetak)
// ==========================================

// Halaman Utama / Landing Page
Route::get('/', [StudentController::class, 'index'])->name('student.index');
Route::get('/landing', [StudentController::class, 'index'])->name('student.landing');

// Halaman Katalog & Form Peminjaman terpisah
Route::get('/katalog', [StudentController::class, 'katalog'])->name('student.katalog');
Route::get('/pinjam', [StudentController::class, 'pinjam'])->name('student.pinjam');
Route::get('/tiket', [StudentController::class, 'lookupTicket'])->name('student.ticket.lookup');
Route::get('/tiket/{loan:ticket_number}', [StudentController::class, 'showTicket'])->name('student.ticket.show');

// Papan Diskusi / Forum Pertanyaan
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');

// Proses Pengiriman Form & Cetak Surat (Tetap ke Controller Anda)
Route::post('/loan', [StudentController::class, 'storeLoan'])->name('student.loan.store');
Route::get('/loan/{ticket_number}/print', [StudentController::class, 'printPermit'])->name('student.loan.print');
Route::get('/loan/{ticket_number}/download', [StudentController::class, 'downloadPdf'])->name('student.loan.download');

// ==========================================
// 2. Autentikasi Pengelola (Admin)
// ==========================================
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// ==========================================
// 3. Panel Pengelola (Wajib Login)
// ==========================================
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.index');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/persetujuan', [AdminController::class, 'persetujuan'])->name('admin.persetujuan');
    Route::get('/inventaris', [AdminController::class, 'inventaris'])->name('admin.inventaris');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/laporan/export', [AdminController::class, 'exportLaporan'])->name('admin.laporan.export');
    Route::patch('/loan/{id}/approve', [AdminController::class, 'approveLoan'])->name('admin.loan.approve');
    Route::patch('/loan/{id}/reject', [AdminController::class, 'rejectLoan'])->name('admin.loan.reject');
    Route::match(['patch', 'post'], '/loan/{id}/return', [AdminController::class, 'markAsReturned'])->name('admin.loan.return');
    Route::match(['patch', 'post'], '/loan/{id}/mark-as-returned', [AdminController::class, 'markAsReturned'])->name('admin.loan.markAsReturned');
    Route::post('/items', [AdminController::class, 'storeItem'])->name('admin.item.store');
});
