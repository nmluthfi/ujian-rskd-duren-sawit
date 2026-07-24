<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Ambil data pasien + riwayat pendaftarannya berdasarkan no. RM (query param: patient_medical_number)
Route::get('/registrations', [RegistrationController::class, 'apiIndex'])->name('api.registrations.index');
