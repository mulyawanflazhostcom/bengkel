# Sistem Informasi Bengkel

Aplikasi web manajemen bengkel berbasis **Laravel** + **SQLite** sesuai spesifikasi tugas (`specs.txt`).

## Fitur

- **Auth** — login, registrasi, logout (session untuk web, Sanctum token untuk API)
- **CRUD** — Pelanggan, Kendaraan, Transaksi (servis & penjualan), lengkap dengan pencarian, filter, dan pagination
- **Relasi antar tabel** — Pelanggan → Kendaraan → Transaksi → Mekanik (Eloquent relationships)
- **Dashboard** — statistik pelanggan, kendaraan, servis, penjualan, dan pendapatan
- **API dengan Sanctum**:
  - `POST /api/login` — tukar email+password dengan Bearer token
  - `GET /api/services` — daftar transaksi servis (JSON, wajib token)
  - `GET /api/customers` — daftar pelanggan (JSON, wajib token)
  - `POST /api/logout` — cabut token
- **Tampilan responsive** (mobile-first, Bootstrap 5)

## Entitas

| Entitas | Tabel | Keterangan |
|---|---|---|
| Mekanik/Admin | `users` | kolom `role`: admin / mekanik |
| Pelanggan | `customers` | nama, HP, email, alamat |
| Kendaraan | `vehicles` | milik pelanggan; plat unik, motor/mobil |
| Transaksi | `transactions` | servis/penjualan; relasi ke pelanggan, kendaraan, mekanik |

## Cara Menjalankan

```bash
composer install
cp .env.example .env        # bila belum ada .env
php artisan key:generate    # bila belum ada APP_KEY
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Buka http://127.0.0.1:8000

## Akun Demo (hasil seeder)

| Email | Password | Role |
|---|---|---|
| admin@bengkel.test | password | admin |
| budi@bengkel.test | password | mekanik |
| sari@bengkel.test | password | mekanik |

## Contoh Pemakaian API

```bash
# 1. Ambil token
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" -H "Accept: application/json" \
  -d '{"email":"admin@bengkel.test","password":"password"}'

# 2. Pakai token
curl http://127.0.0.1:8000/api/services \
  -H "Accept: application/json" \
  -H "Authorization: Bearer <TOKEN>"

curl http://127.0.0.1:8000/api/customers \
  -H "Accept: application/json" \
  -H "Authorization: Bearer <TOKEN>"
```

Format response API konsisten: `{ "success": bool, "message": string, "data": ... }`.

## Struktur Kode (MVC)

- **Model** — `app/Models/{User,Customer,Vehicle,Transaction}.php` (Eloquent + relasi, tanpa raw SQL)
- **View** — `resources/views/` (Blade + Bootstrap 5, layout di `layouts/app.blade.php`)
- **Controller** — `app/Http/Controllers/` (resource controller + validasi input), API di `app/Http/Controllers/Api/`
- **Routes** — `routes/web.php` (session auth) dan `routes/api.php` (Sanctum)
# bengkel
