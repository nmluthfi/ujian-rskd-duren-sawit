<?php

namespace Database\Seeders;

use App\Models\Registration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List data registration
        Registration::insert([
            [
                "patient_medical_number" => "05358",
                "polyclinic_id" => 1,
                "registration_date" => "2026-05-03 08:03:00",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "patient_medical_number" => "05456",
                "polyclinic_id" => 3,
                "registration_date" => "2026-05-03 07:56:00",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "patient_medical_number" => "05135",
                "polyclinic_id" => 2,
                "registration_date" => "2026-05-01 08:47:00",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "patient_medical_number" => "05268",
                "polyclinic_id" => 2,
                "registration_date" => "2026-05-01 08:40:00",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "patient_medical_number" => "05358",
                "polyclinic_id" => 1,
                "registration_date" => "2026-06-05 08:03:00",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}
