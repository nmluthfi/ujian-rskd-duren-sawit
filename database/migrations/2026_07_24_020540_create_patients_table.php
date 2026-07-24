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
        Schema::create('patients', function (Blueprint $table) {
            $table->string('medical_number')->primary();
            $table->string('name'); // Nama Lengkap
            $table->date('birth_of_date'); // Tanggal Lahir (DD-MM-YYYY)
            $table->string('sex'); // L = Laki-laki, P = Perempuan
            $table->string('address'); // Alamat Lengkap Sesuai KTP
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
