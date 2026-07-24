# Sistem Informasi Pendaftaran Pasien ke Poliklinik

Aplikasi web sederhana untuk mendaftarkan pasien yang **sudah terdaftar** (punya Nomor Rekam Medis / No. RM) ke sebuah poliklinik di rumah sakit. Dibuat sebagai latihan/simulasi ujian praktik.

## Apa yang bisa dilakukan aplikasi ini?

1. **Admin mencari data pasien** dengan memasukkan No. RM (Nomor Rekam Medis).
   - Kalau No. RM valid, data pasien (nama, tanggal lahir, jenis kelamin, alamat) langsung tampil di layar.
   - Kalau No. RM tidak ditemukan, muncul pesan error yang jelas.
2. **Admin mendaftarkan pasien tersebut ke sebuah poliklinik** (misalnya Poliklinik Mata, Poliklinik Gigi, dll) dengan memilih dari daftar yang tersedia. Waktu pendaftaran otomatis dicatat sesuai jam saat tombol "Daftarkan" diklik — admin tidak perlu input tanggal/jam manual.
3. **Sistem lain bisa mengambil riwayat pendaftaran seorang pasien** lewat sebuah alamat API (lihat bagian "Dokumentasi API" di bawah), dengan opsi menyaring berdasarkan rentang tanggal.

## Tech Stack (teknologi yang dipakai)

| Bagian | Teknologi |
|---|---|
| Bahasa pemrograman | PHP 8.5 |
| Framework | Laravel 13 |
| Database | Microsoft SQL Server 2022 (berjalan via Docker) |
| Package manager PHP | Composer |
| Environment lokal | Docker Desktop (buat menjalankan database) |

## Struktur Data (Database)

Ada 3 tabel utama:

- **`patients`** — data pasien yang sudah terdaftar di rumah sakit (No. RM, nama, tanggal lahir, jenis kelamin, alamat).
- **`polyclinics`** — daftar poliklinik yang tersedia (Mata, Gigi, Umum, dll).
- **`registrations`** — catatan setiap kali seorang pasien didaftarkan ke sebuah poliklinik (menghubungkan `patients` dan `polyclinics`, plus waktu pendaftaran).

## Prasyarat Sebelum Menjalankan

Sebelum menjalankan aplikasi ini di komputer lain, pastikan sudah terinstall:

1. **PHP 8.3 atau lebih baru** beserta extension `sqlsrv` dan `pdo_sqlsrv` (dibutuhkan supaya PHP bisa "ngobrol" dengan database SQL Server)
2. **Composer** (package manager PHP)
3. **Docker Desktop** (buat menjalankan database SQL Server secara lokal)
4. **Microsoft ODBC Driver 18 for SQL Server** (jembatan teknis antara PHP dan SQL Server)

## Cara Menjalankan Aplikasi

### 1. Jalankan database (SQL Server via Docker)

```bash
docker start sqlserver-ujian-rskd-duren-sawit
```

Kalau container-nya belum pernah dibuat sama sekali, gunakan (hanya sekali saja):

```bash
docker run --platform linux/amd64 -e "ACCEPT_EULA=Y" -e "MSSQL_SA_PASSWORD=<password_pilihanmu>" -p 1434:1433 --name sqlserver-ujian-rskd-duren-sawit -d mcr.microsoft.com/mssql/server:2022-latest
```

### 2. Install dependency PHP

```bash
composer install
```

### 3. Siapkan file konfigurasi environment

Salin `.env.example` menjadi `.env`, lalu sesuaikan bagian koneksi database:

```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1434
DB_DATABASE=rskd_duren_sawit
DB_USERNAME=sa
DB_PASSWORD=<password_sesuai_container_docker>
DB_TRUST_SERVER_CERTIFICATE=true
```

### 4. Buat tabel-tabel database + isi data contoh

```bash
php artisan migrate:fresh --seed
```

### 5. Jalankan aplikasinya

```bash
php artisan serve
```

Buka browser ke: **http://127.0.0.1:8000/registrations**

## Cara Pakai (dari sisi pengguna/admin)

1. Buka halaman `http://127.0.0.1:8000/registrations`.
2. Masukkan No. RM pasien di kolom pencarian (contoh data yang sudah tersedia: `05358`, `05456`, `05135`, `05268`), klik **Cari**.
3. Kalau data pasien muncul, pilih poliklinik tujuan dari dropdown, lalu klik **Daftarkan**.
4. Muncul pesan konfirmasi kalau pendaftaran berhasil disimpan.

## Dokumentasi API

### Ambil data pasien + riwayat pendaftarannya

```
GET /api/registrations
```

**Parameter (dikirim lewat query string di URL):**

| Nama | Wajib? | Keterangan |
|---|---|---|
| `patient_medical_number` | Ya | No. RM pasien yang mau dicek datanya |
| `date_from` | Tidak | Cuma tampilkan riwayat pendaftaran mulai dari tanggal ini (format: `YYYY-MM-DD`) |
| `date_to` | Tidak | Cuma tampilkan riwayat pendaftaran sampai tanggal ini (format: `YYYY-MM-DD`) |

**Contoh pemanggilan:**

```
GET /api/registrations?patient_medical_number=05358
GET /api/registrations?patient_medical_number=05358&date_from=2026-07-21&date_to=2026-07-23
```

**Contoh response (format JSON):**

```json
{
  "data_pasien": {
    "medical_number": "05358",
    "name": "Samsuri",
    "birth_of_date": "1980-11-22",
    "sex": "L",
    "address": "Jln Raya Bekasi No.32, Bekasi"
  },
  "riwayat_pendaftaran": [
    {
      "id": 1,
      "polyclinic_name": "Poliklinik Mata",
      "registration_date": "2026-05-03 15:03:00"
    }
  ]
}
```

**Kalau `patient_medical_number` kosong atau No. RM-nya nggak ditemukan**, response-nya `422 Unprocessable Content` dengan pesan error validasi, bukan `data_pasien`/`riwayat_pendaftaran`.

**Catatan tentang waktu**: seluruh waktu **tersimpan di database dalam UTC**, tapi otomatis dikonversi ke **waktu Indonesia Barat (WIB / UTC+7)** sebelum ditampilkan di `registration_date` pada response ini — jadi jam yang kamu lihat di atas sudah waktu lokal Indonesia, tidak perlu dihitung ulang.

## Catatan Teknis Tambahan

- Database `patients` menggunakan No. RM sebagai kunci utama (bukan angka urut otomatis), karena No. RM adalah identitas resmi pasien di dunia nyata, bukan sekadar nomor urut sistem.
- Data yang dihapus (misalnya pasien atau pendaftaran) tidak benar-benar hilang dari database (soft delete) — ini demi keamanan data rekam medis, sesuai praktik umum di sistem informasi rumah sakit.
