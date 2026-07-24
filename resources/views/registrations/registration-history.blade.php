<div style="overflow-x: auto; margin-top: 12px;">
    <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 6px;">No. Registrasi</th>
                <th style="border: 1px solid #ccc; padding: 6px;">No. RM</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Nama</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Tanggal Lahir</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Jenis Kelamin</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Alamat</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Poliklinik</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Tanggal Registrasi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Prefix Bp./Ny. langsung ditulis di sini, satu tempat, gak perlu diduplikasi di JS --}}
            @foreach ($registrations as $registration)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 6px;">{{ $registration->id }}</td>
                    <td style="border: 1px solid #ccc; padding: 6px;">{{ $registration->patient_medical_number }}</td>
                    <td style="border: 1px solid #ccc; padding: 6px;">
                        {{ trim($registration->patient->sex) == 'L' ? 'Bp.' : 'Ny.' }} {{ $registration->patient->name }}
                    </td>
                    <td style="border: 1px solid #ccc; padding: 6px;">
                        {{ $registration->patient->birth_of_date->format('d-m-Y') }}
                    </td>
                    <td style="border: 1px solid #ccc; padding: 6px;">{{ $registration->patient->sex }}</td>
                    <td style="border: 1px solid #ccc; padding: 6px;">{{ $registration->patient->address }}</td>
                    <td style="border: 1px solid #ccc; padding: 6px;">{{ $registration->polyclinic->name }}</td>
                    <td style="border: 1px solid #ccc; padding: 6px;">
                        {{ $registration->registration_date->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>