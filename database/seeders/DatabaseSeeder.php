<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        $budi = User::create([
            'name' => 'Budi Mekanik',
            'email' => 'budi@bengkel.test',
            'password' => Hash::make('password'),
            'role' => 'mekanik',
            'phone' => '081234567891',
        ]);

        $sari = User::create([
            'name' => 'Sari Mekanik',
            'email' => 'sari@bengkel.test',
            'password' => Hash::make('password'),
            'role' => 'mekanik',
            'phone' => '081234567892',
        ]);

        $andi = Customer::create([
            'name' => 'Andi Wijaya',
            'phone' => '081298765431',
            'email' => 'andi@example.com',
            'address' => 'Jl. Merdeka No. 10, Jakarta',
        ]);

        $rina = Customer::create([
            'name' => 'Rina Puspita',
            'phone' => '081298765432',
            'email' => 'rina@example.com',
            'address' => 'Jl. Sudirman No. 25, Bandung',
        ]);

        $joko = Customer::create([
            'name' => 'Joko Santoso',
            'phone' => '081298765433',
            'email' => null,
            'address' => 'Jl. Diponegoro No. 7, Surabaya',
        ]);

        $beatAndi = Vehicle::create([
            'customer_id' => $andi->id,
            'plate_number' => 'B 1234 ABC',
            'type' => 'motor',
            'brand' => 'Honda',
            'model' => 'Beat',
            'year' => 2021,
        ]);

        $avanzaRina = Vehicle::create([
            'customer_id' => $rina->id,
            'plate_number' => 'D 5678 DEF',
            'type' => 'mobil',
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'year' => 2019,
        ]);

        $nmaxJoko = Vehicle::create([
            'customer_id' => $joko->id,
            'plate_number' => 'L 9012 GHI',
            'type' => 'motor',
            'brand' => 'Yamaha',
            'model' => 'NMAX',
            'year' => 2023,
        ]);

        Transaction::create([
            'code' => 'SRV-20260715-0001',
            'type' => 'servis',
            'customer_id' => $andi->id,
            'vehicle_id' => $beatAndi->id,
            'user_id' => $budi->id,
            'date' => '2026-07-15',
            'description' => 'Servis rutin + ganti oli mesin',
            'total' => 150000,
            'status' => 'dibayar',
        ]);

        Transaction::create([
            'code' => 'SRV-20260718-0002',
            'type' => 'servis',
            'customer_id' => $rina->id,
            'vehicle_id' => $avanzaRina->id,
            'user_id' => $sari->id,
            'date' => '2026-07-18',
            'description' => 'Ganti kampas rem depan + tune up mesin',
            'total' => 750000,
            'status' => 'dikerjakan',
        ]);

        Transaction::create([
            'code' => 'SRV-20260720-0003',
            'type' => 'servis',
            'customer_id' => $joko->id,
            'vehicle_id' => $nmaxJoko->id,
            'user_id' => $budi->id,
            'date' => '2026-07-20',
            'description' => 'Ganti ban belakang + servis CVT',
            'total' => 450000,
            'status' => 'menunggu',
        ]);

        Transaction::create([
            'code' => 'PJL-20260719-0001',
            'type' => 'penjualan',
            'customer_id' => $andi->id,
            'vehicle_id' => null,
            'user_id' => $admin->id,
            'date' => '2026-07-19',
            'description' => 'Penjualan oli mesin 1L + busi',
            'total' => 95000,
            'status' => 'dibayar',
        ]);
    }
}
