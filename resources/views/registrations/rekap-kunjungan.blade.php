<div style="overflow-x: auto; margin-top: 12px;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 6px;">No.</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Nama Poliklinik</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Jumlah Pasien</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($polyclinics as $index => $polyclinic)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 6px;">{{ $index + 1 }}</td>
                    <td style="border: 1px solid #ccc; padding: 6px;">{{ $polyclinic->name }}</td>
                    <td style="border: 1px solid #ccc; padding: 6px;">{{ $polyclinic->registrations_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
