<!DOCTYPE html>
<html>

<head>
    <title>Pendaftaran Pasien ke Poliklinik</title>
    <style>
        /* Styling dasar biar gak terlalu polos, tapi tetap simpel */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 16px;
            margin-top: 24px;
            margin-bottom: 12px;
            border-top: 1px solid #eee;
            padding-top: 16px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 13px;
            color: #555;
            margin-bottom: 4px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Field readonly (biodata pasien) dikasih background beda biar keliatan gak bisa diedit */
        input[readonly] {
            background-color: #f0f0f0;
            color: #333;
        }

        button {
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            background-color: #2563eb;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        button:disabled {
            background-color: #aaa;
            cursor: not-allowed;
        }

        .message-success {
            background-color: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 16px;
        }

        .message-error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <div class="container">

        <h1>Pendaftaran Pasien ke Poliklinik</h1>

        {{-- Pesan sukses setelah submit berhasil --}}
        @if (session('success'))
            <div class="message-success">{{ session('success') }}</div>
        @endif

        {{-- Pesan error kalau pasien gak ketemu --}}
        @if ($error)
            <div class="message-error">{{ $error }}</div>
        @endif

        {{-- Form cari pasien berdasarkan No. RM --}}
        <form method="GET" action="{{ route('registrations.index') }}" id="search-form">
            <div class="form-group">
                <label for="no_rm">No. RM</label>
                <input type="text" id="no_rm" name="no_rm" value="{{ $noRm }}">
            </div>
            <button type="submit" id="search-button" disabled>Cari</button>
        </form>

        <script>
            const noRmInput = document.getElementById('no_rm');
            const searchButton = document.getElementById('search-button');

            function toggleSearchButton() {
                searchButton.disabled = noRmInput.value.trim() === '';
            }

            toggleSearchButton();
            noRmInput.addEventListener('input', toggleSearchButton);
        </script>

        <h2>Data Pasien</h2>

        {{-- Form pendaftaran. Field biodata SELALU tampil (bukan hidden), tapi readonly.
        Kosong kalau belum ada hasil pencarian, otomatis terisi setelah search valid.
        Pakai operator ?? '' (null-safe) supaya gak error kalau $patient masih null. --}}
        <form method="POST" action="{{ route('registrations.store') }}">
            @csrf

            <div class="form-group">
                <label for="medical_number">No. RM</label>
                {{-- readonly (bukan hidden/disabled) supaya tetap ikut ter-submit di form --}}
                <input type="text" id="medical_number" name="patient_medical_number"
                    value="{{ $patient->medical_number ?? '' }}" readonly>
            </div>

            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" value="{{ $patient->name ?? '' }}" readonly>
            </div>

            <div class="form-group">
                <label for="birth_of_date">Tanggal Lahir</label>
                <input type="text" id="birth_of_date" value="{{ $patient?->birth_of_date?->format('d-m-Y') ?? '' }}"
                    readonly>
            </div>

            <div class="form-group">
                <label for="sex">Jenis Kelamin</label>
                <input type="text" id="sex" value="{{ $patient->sex ?? '' }}" readonly>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" id="address" value="{{ $patient->address ?? '' }}" readonly>
            </div>

            <h2>Daftarkan ke Poliklinik</h2>

            <div class="form-group">
                <label for="polyclinic_id">Poliklinik</label>
                <select name="polyclinic_id" id="polyclinic_id" @if (!$patient) disabled @endif>
                    <option value="">-- Pilih Poliklinik --</option>
                    @foreach ($polyclinics as $polyclinic)
                        <option value="{{ $polyclinic->id }}">{{ $polyclinic->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol daftar disabled kalau belum ada pasien valid ditemukan --}}
            <button type="submit" @if (!$patient) disabled @endif>Daftarkan</button>
            <button type="button" id="history-button">Tampilkan Riwayat Registrasi</button>
            <button type="button" id="rekap-kunjungan-button">Ekspor Rekap Kunjungan</button>
        </form>
        {{-- Container kosong, diisi HTML langsung dari server lewat fetch() --}}
        <div id="history-container"></div>

        <script>
            document.getElementById('history-button')?.addEventListener('click', function () {
                // Gak perlu medicalNumber lagi - endpoint ini balikin SEMUA data registrasi
                fetch(`/registrations/registration-history`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('history-container').innerHTML = html;
                    });
            });

            document.getElementById('rekap-kunjungan-button')?.addEventListener('click', function () {
                // Rekap jumlah pasien per poliklinik, sudah diurutkan terbanyak ke tersedikit dari server
                fetch(`/registrations/rekap-kunjungan`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('history-container').innerHTML = html;
                    });
            });
        </script>
    </div>
</body>

</html>