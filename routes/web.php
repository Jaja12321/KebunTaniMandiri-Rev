<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\LokasiSawitController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\RekapKerjaController;
use App\Http\Controllers\RekapProduksiController;
use App\Http\Controllers\RawatController;
use App\Http\Controllers\LaporanKeuanganController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\Auth\ForgotPasswordOtpController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|p
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::resource('karyawan', KaryawanController::class);  // Menambahkan resource routes untuk Karyawan
Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');


Route::get('/blank', function () {
    return view('blank');
})->name('blank');

Route::middleware('auth')->group(function() {
    Route::resource('basic', BasicController::class);
});

// Route untuk melihat semua data kehadiran
Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');

// Route untuk form tambah kehadiran
Route::get('/kehadiran/create', [KehadiranController::class, 'create'])->name('kehadiran.create');

// Route untuk form edit kehadiran
Route::get('/kehadiran/{id}/edit', [KehadiranController::class, 'edit'])->name('kehadiran.edit');

// Route untuk menyimpan data kehadiran
Route::post('/kehadiran', [KehadiranController::class, 'store'])->name('kehadiran.store');

// Route untuk mengupdate data kehadiran
Route::put('/kehadiran/{id}', [KehadiranController::class, 'update'])->name('kehadiran.update');

// Route untuk menghapus data kehadiran
Route::delete('/kehadiran/{id}', [KehadiranController::class, 'destroy'])->name('kehadiran.destroy');

Route::get('/lokasi-sawit', [LokasiSawitController::class, 'index'])->name('lokasi_sawit.index');

// Rute untuk menampilkan form tambah lokasi sawit
Route::get('/lokasi-sawit/create', [LokasiSawitController::class, 'create'])->name('lokasi_sawit.create');

// Rute untuk menyimpan data lokasi sawit
Route::post('/lokasi-sawit', [LokasiSawitController::class, 'store'])->name('lokasi_sawit.store');

// Rute untuk menampilkan form edit lokasi sawit
Route::get('/lokasi-sawit/{id}/edit', [LokasiSawitController::class, 'edit'])->name('lokasi_sawit.edit');

// Rute untuk memperbarui data lokasi sawit
Route::put('/lokasi-sawit/{id}', [LokasiSawitController::class, 'update'])->name('lokasi_sawit.update');

// Rute untuk menghapus data lokasi sawit
Route::delete('/lokasi-sawit/{id}', [LokasiSawitController::class, 'destroy'])->name('lokasi_sawit.destroy');


// Resource routes untuk Panen (CRUD)
Route::get('/panen', [PanenController::class, 'index'])->name('panen.index');
Route::get('/panen/create', [PanenController::class, 'create'])->name('panen.create');
Route::post('/panen', [PanenController::class, 'store'])->name('panen.store');
Route::get('/panen/{panen}/edit', [PanenController::class, 'edit'])->name('panen.edit');
Route::put('/panen/{panen}', [PanenController::class, 'update'])->name('panen.update');
Route::delete('/panen/{panen}', [PanenController::class, 'destroy'])->name('panen.destroy');

Route::get('/rekap-kerja', [RekapKerjaController::class, 'index'])->name('rekap_kerja.index');

// Parameter karyawan_id di URL untuk form tambah rekap kerja
Route::get('/rekap-kerja/create/{karyawan_id}', [RekapKerjaController::class, 'create'])->name('rekap_kerja.create');

Route::post('/rekap-kerja', [RekapKerjaController::class, 'store'])->name('rekap_kerja.store');

Route::get('/rekap-kerja/{id}/detail', [RekapKerjaController::class, 'detail'])->name('rekap_kerja.detail');

Route::get('/rekap-produksi', [RekapProduksiController::class, 'index'])->name('rekap.index');
Route::post('/rekap-kerja/tambah-hutang', [RekapKerjaController::class, 'storeHutang'])->name('rekap_kerja.store_hutang');
Route::put('/rekap-kerja/{hutang}/kurangi-hutang', [RekapKerjaController::class, 'kurangiHutang'])->name('rekap_kerja.kurangi_hutang');
Route::delete('/rekap-kerja/{hutang}/hapus-hutang', [RekapKerjaController::class, 'hapusHutang'])->name('rekap_kerja.hapus_hutang');

Route::get('/rekap-kerja/{id}/edit', [RekapKerjaController::class, 'edit'])->name('rekap_kerja.edit');
Route::put('/rekap-kerja/{id}', [RekapKerjaController::class, 'update'])->name('rekap_kerja.update');
Route::delete('/rekap-kerja/{id}', [RekapKerjaController::class, 'destroy'])->name('rekap_kerja.destroy');

Route::resource('rawat', RawatController::class);

Route::get('/laporan/keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.keuangan');

Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::get('laporan/cetak-pdf', [LaporanKeuanganController::class, 'cetakPdf'])->name('laporan.keuangan.cetakPdf');

Auth::routes();

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Halaman login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('login', [LoginController::class, 'login']);

// Proses logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/fitur', function () {
    return view('fitur.index');
})->name('fitur.index');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/mandor/dashboard', function () {
    return view('dashboards.mandor');
})->name('mandor.dashboard')->middleware('auth');

Route::get('/pemilik/dashboard', function () {
    return view('dashboards.pemilik');
})->name('pemilik.dashboard')->middleware('auth');

Route::resource('features', FeatureController::class)->middleware(['auth']);

Route::get('/rekap/cetak', [RekapProduksiController::class, 'cetakPDF'])->name('rekap.cetak');

Route::prefix('laporan')->group(function () {
    Route::get('/keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.keuangan');
    Route::get('/keuangan/pdf', [LaporanKeuanganController::class, 'cetakPdf'])->name('laporan.keuangan.pdf');
});

Route::get('/laporan-bulanan', [LaporanBulananController::class, 'index'])->name('laporan_bulanan.index');
Route::get('/laporan-bulanan/cetak', [LaporanBulananController::class, 'cetak'])->name('laporan_bulanan.cetak');

Route::get('/forgot-password-otp', [ForgotPasswordOtpController::class, 'showOtpForm'])->name('otp.form');
Route::post('/forgot-password-otp', [ForgotPasswordOtpController::class, 'sendOtp'])->name('otp.send');
Route::get('/verify-otp', [ForgotPasswordOtpController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/verify-otp', [ForgotPasswordOtpController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/reset-password-otp', [ForgotPasswordOtpController::class, 'resetPassword'])->name('otp.reset');

Route::get('/rekap-kerja/{id}/edit', [RekapKerjaController::class, 'edit'])->name('rekap_kerja.edit');
Route::delete('/rekap-kerja/{id}', [RekapKerjaController::class, 'destroy'])->name('rekap_kerja.destroy');

Route::get('/rekap-kerja/{id}/form-hutang', [RekapKerjaController::class, 'formHutang'])->name('rekap_kerja.form_hutang');
Route::post('/rekap-kerja/proses-hutang', [RekapKerjaController::class, 'prosesHutang'])->name('rekap_kerja.proses_hutang');

Route::get('/rekap-kerja/print/{id}', [RekapKerjaController::class, 'generateRekapKerjaPDF'])->name('rekap_kerja.generateRekapKerjaPDF');

// Route for generating Slip Gaji PDF
Route::get('/rekap-kerja/slip-gaji/print/{id}', [RekapKerjaController::class, 'generateSlipGajiPDF'])->name('rekap_kerja.generateSlipGajiPDF');

Route::get('/dashboard', function () {
    return view('dashboard'); // Ganti 'dashboard' dengan tampilan yang sesuai dengan aplikasi Anda
})->name('dashboard');  // Menambahkan nama rute 'dashboard'

// Route untuk melihat history kehadiran karyawan
Route::get('/kehadiran/history/{karyawan_id}', [KehadiranController::class, 'history'])->name('kehadiran.history');
 
Route::resource('lokasi_sawit2', LokasiSawitController::class);
