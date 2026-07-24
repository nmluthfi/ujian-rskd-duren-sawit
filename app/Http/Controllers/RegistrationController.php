<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegistrationResource;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Halaman utama: search pasien by no_rm + form daftar ke poliklinik.
     * Setelah submit berhasil, cukup tampilkan pesan konfirmasi (bukan list registrasi -
     * itu fitur terpisah).
     */
    public function index(Request $request)
    {
        // Data buat dropdown pilihan poliklinik di form
        $polyclinics = Polyclinic::all();

        // Ambil no_rm dari query string (misal /registrations?no_rm=1001)
        $noRm = $request->query('no_rm');

        $patient = null;
        $error = null;

        if ($noRm) {
            $patient = Patient::find($noRm);

            if (!$patient) {
                $error = 'No. RM tidak ditemukan. Pastikan nomor rekam medis sudah benar.';
            }
        }

        return view('registrations.index', [
            'polyclinics' => $polyclinics,
            'patient' => $patient,
            'error' => $error,
            'noRm' => $noRm,
        ]);
    }

    /**
     * Proses pendaftaran pasien ke poliklinik.
     * Kalau berhasil -> redirect balik dengan pesan sukses (flash message).
     * Kalau validasi gagal -> redirect balik dengan pesan error otomatis dari Laravel.
     */
    public function store(Request $request)
    {
        // Validasi input: pastikan pasien & poliklinik yang dipilih memang ada di database
        $validated = $request->validate([
            'patient_medical_number' => 'required|exists:patients,medical_number',
            'polyclinic_id' => 'required|exists:polyclinics,id',
        ]);

        // Tambahkan registration_date manual, diambil dari waktu server saat ini
        $validated['registration_date'] = now();

        // Simpan data registrasi baru
        Registration::create($validated);

        // Redirect balik ke halaman yang sama, sambil bawa pesan sukses via session flash
        return redirect()
            ->route('registrations.index')
            ->with('success', 'Pasien berhasil didaftarkan ke poliklinik.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * GET endpoint: ambil riwayat registrasi pasien.
     * Wajib: patient_medical_number (query param)
     * Opsional: date_from, date_to (filter rentang tanggal registrasi)
     * Return: JSON
     */
    public function apiIndex(Request $request)
    {
        // Validasi: patient_medical_number wajib ada dan harus pasien yang beneran terdaftar
        $validated = $request->validate([
            'patient_medical_number' => 'required|exists:patients,medical_number',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
        ]);

        // Data pasien yang dicari, ditampilkan terpisah dari riwayat pendaftarannya
        $patient = Patient::findOrFail($validated['patient_medical_number']);

        // Mulai query dasar: filter by patient_medical_number (wajib)
        $query = Registration::where('patient_medical_number', $validated['patient_medical_number'])
            ->with('polyclinic'); // eager load supaya nama poliklinik ikut ke-load

        // Params date_from dan date_to bersifat optional.
        // Ketika digunakan akan memfilter hasil data registrasi pasien berdasarkan tanggal dari dan sampai terpilih
        $query->when($request->filled('date_from'), function ($q) use ($validated) {
            $q->whereDate('registration_date', '>=', $validated['date_from']);
        });
        $query->when($request->filled('date_to'), function ($q) use ($validated) {
            $q->whereDate('registration_date', '<=', $validated['date_to']);
        });

        // Memfilter result API berdasarkan urutan ID registrasi secara low-to-high
        $registrations = $query->orderBy('id', 'asc')->get();

        return response()->json([
            'data_pasien' => [
                'medical_number' => $patient->medical_number,
                'name' => $patient->name,
                'birth_of_date' => $patient->birth_of_date->format('Y-m-d'),
                'sex' => $patient->sex,
                'address' => $patient->address,
            ],
            'riwayat_pendaftaran' => RegistrationResource::collection($registrations),
        ]);
    }

    /**
     * Endpoint khusus fitur "Riwayat Registrasi" - tampilkan SEMUA data registrasi
     * (bukan cuma 1 pasien), gak butuh no_rm sama sekali.
     */
    public function registrationHistory()
    {
        $registrations = Registration::with(['polyclinic', 'patient'])
            ->orderBy('id', 'asc')
            ->get();

        return view('registrations.registration-history', ['registrations' => $registrations]);
    }
}
