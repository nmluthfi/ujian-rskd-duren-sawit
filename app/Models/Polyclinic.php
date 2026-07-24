<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polyclinic extends Model
{
    // Mendefinisikan kolom mana saja yang boleh diisi
    protected $fillable = [
        'name',
    ];

    /*
     * Definisi relasi one-to-many pada model Polyclinic.
     * satu poliklinik bisa punya banyak registrasi (kunjungan pasien)
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
