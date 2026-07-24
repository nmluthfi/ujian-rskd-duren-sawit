<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    // Konfigurasi khusus untuk medical number karena bukan auto increment
    protected $primaryKey = 'medical_number';
    public $incrementing = false;
    protected $keyType = 'int';

    // Mendefinisikan kolom mana saja yang boleh diisi
    protected $fillable = [
        "medical_number",
        "birth_of_date",
        "sex",
        "address",
    ];

    // Cast kolom birth_of_date jadi objek Carbon otomatis, biar bisa pakai ->format()
    protected $casts = [
        'birth_of_date' => 'date',
    ];
}
