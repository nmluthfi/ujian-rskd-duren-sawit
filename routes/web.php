<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Menampilkan halaman utama: form search pasien by no_rm + form daftar ke poliklinik
Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');

// Memproses submit form pendaftaran pasien ke poliklinik
Route::post('registrations', [RegistrationController::class, 'store'])->name('registrations.store');

// Menampilakn riwayat history seluruh pasien yang sudah terdaftar di semua poliklinik
Route::get('/registrations/registration-history', [RegistrationController::class, 'registrationHistory'])->name('registrations.registration-history');


