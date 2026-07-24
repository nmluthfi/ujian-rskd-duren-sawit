<?php

namespace Database\Seeders;

use App\Models\Polyclinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolyclinicSeeder extends Seeder
{
    /**
     * Menambahkan data dummy poliklinik ke dalam Polyclinics
     */
    public function run(): void
    {
        // List data poliklinik
        Polyclinic::insert([
            [
                "name" => "Poliklinik Mata",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Poliklinik Penyakit Dalam",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Poliklinik Jantung",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}
