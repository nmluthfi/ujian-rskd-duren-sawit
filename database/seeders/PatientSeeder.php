<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Menambahkan dummy data pasien ke dalam tabel Patients
     */
    public function run(): void
    {
        // List data pasien
        Patient::insert([
            [
                "medical_number" => "05358",
                "name" => "Samsuri",
                "birth_of_date" => "1980-11-22",
                "sex" => "L",
                "address" => "Jln Raya Bekasi No.32, Bekasi",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "medical_number" => "05456",
                "name" => "Egi Pasaribu",
                "birth_of_date" => "1976-05-02",
                "sex" => "P",
                "address" => "Jln Majapahit No.22, Jakarta",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'medical_number' => "05135",
                'name' => 'Setyo Prabowo',
                'birth_of_date' => '1964-12-07',
                'sex' => 'L',
                'address' => 'Jln Laksmana No. 01, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "medical_number" => "05268",
                "name" => "Haryanti",
                "birth_of_date" => "1989-10-26",
                "sex" => "P",
                "address" => "Jln. Deli, Koja, Jakarta Utara",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}
