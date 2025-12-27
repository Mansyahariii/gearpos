<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS (password DI-HASH, WAJIB)
        |--------------------------------------------------------------------------
        */
        $users = [
            [
                'nama' => 'Pemilik Toko',
                'username' => 'pemilik',
                'password' => 'password',
                'role' => 'pemilik',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Manajer Toko',
                'username' => 'manajer',
                'password' => 'password',
                'role' => 'manajer',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Kasir',
                'username' => 'kasir',
                'password' => 'password',
                'role' => 'kasir',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Staf Gudang',
                'username' => 'gudang',
                'password' => 'password',
                'role' => 'staf_gudang',
                'status' => 'aktif',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'nama' => $user['nama'],
                'username' => $user['username'],
                'password' => Hash::make($user['password']),
                'role' => $user['role'],
                'status' => $user['status'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */
        $kategoris = [
            ['nama_kategori' => 'Oli & Pelumas'],
            ['nama_kategori' => 'Ban & Velg'],
            ['nama_kategori' => 'Aki & Kelistrikan'],
            ['nama_kategori' => 'Filter'],
            ['nama_kategori' => 'Rem'],
            ['nama_kategori' => 'Mesin'],
            ['nama_kategori' => 'Body & Eksterior'],
            ['nama_kategori' => 'Aksesoris'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        /*
        |--------------------------------------------------------------------------
        | BARANG / PRODUK
        |--------------------------------------------------------------------------
        */
        $barangs = [
            [
                'nama_barang' => 'Oli Mesin Yamalube 1L',
                'kategori_id' => 1,
                'harga_beli' => 35000,
                'harga_jual' => 45000,
                'stok' => 50,
                'satuan' => 'botol',
                'lokasi_rak' => 'A-01',
            ],
            [
                'nama_barang' => 'Ban Luar IRC 80/90-17',
                'kategori_id' => 2,
                'harga_beli' => 150000,
                'harga_jual' => 185000,
                'stok' => 20,
                'satuan' => 'pcs',
                'lokasi_rak' => 'B-01',
            ],
            [
                'nama_barang' => 'Aki GS Astra GTZ5S',
                'kategori_id' => 3,
                'harga_beli' => 180000,
                'harga_jual' => 220000,
                'stok' => 15,
                'satuan' => 'pcs',
                'lokasi_rak' => 'C-01',
            ],
            [
                'nama_barang' => 'Filter Udara Honda Beat',
                'kategori_id' => 4,
                'harga_beli' => 25000,
                'harga_jual' => 35000,
                'stok' => 30,
                'satuan' => 'pcs',
                'lokasi_rak' => 'D-01',
            ],
            [
                'nama_barang' => 'Kampas Rem Depan Vario',
                'kategori_id' => 5,
                'harga_beli' => 40000,
                'harga_jual' => 55000,
                'stok' => 25,
                'satuan' => 'set',
                'lokasi_rak' => 'E-01',
            ],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}
