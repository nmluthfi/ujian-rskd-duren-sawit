<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    /**
     * Menentukan field apa saja yang muncul di response JSON.
     * Ini tempat kontrol penuh atas bentuk output API -
     * gak perlu ikutin struktur kolom database apa adanya.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'polyclinic_name' => $this->polyclinic->name, // ambil dari relasi, bukan cuma polyclinic_id
            'registration_date' => $this->registration_date->setTimeZone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ];
    }
}