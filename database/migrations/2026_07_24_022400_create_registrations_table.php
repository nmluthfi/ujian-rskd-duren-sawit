<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // Primary key registrations
            $table->string('patient_medical_number'); // Foreign key nomor rekam medis didapat dari table patient
            $table->foreign('patient_medical_number')->references('medical_number')->on('patients'); // Mereferensikan kolom medical_number pada tabel patients karena dia menggunakan customer indexer
            $table->foreignId('polyclinic_id')->constrained(); // Foreign key ID dari table polyclinics
            $table->dateTime('registration_date'); // Tanggal pasien melakukan registrasi
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
