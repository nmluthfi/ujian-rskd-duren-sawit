<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polyclinic extends Model
{
    // Mendefinisikan kolom mana saja yang boleh diisi
    protected $fillable = [
        'polyclinic_nname',
    ];
}
