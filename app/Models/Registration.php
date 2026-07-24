<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_medical_number',
        'polyclinic_id',
        'registration_date',
    ];

    // Cast registration_date jadi Carbon otomatis, biar bisa dipakai ->format()
    protected $casts = [
        'registration_date' => 'datetime',
    ];

    /*
     * Definisi relasi one-to-many pada model Registration.
     * per satu patient bisa melakukan banyak registrasi
     * perlu 2 parameter tambahan di belongsTo() 
     * karena kolom referensinya bukan default (patient_medical_number bukan patient_id, dan target-nya medical_number bukan id)
     */
    public function patient()
    {
        return $this->belongsTo(
            Patient::class,
            'patient_medical_number',
            'medical_number'
        );
    }

    /*
     * Definisi relasi one-to-many pada model Registration.
     * per satu polyclinic bisa melayani banyak registrasi
     * 
     * Bisa pake default karena colomnnya menggunakan conventional naming (polyclinic_id -> id)
     */
    public function polyclinic()
    {
        return $this->belongsTo(
            Polyclinic::class,
        );
    }
}
