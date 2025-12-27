<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaketLayanan;

class PaketLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pakets = [
            [
                'nama_paket' => 'Paket Hemat 10 Mbps',
                'harga'      => 150000.00,
                'deskripsi'  => 'Cocok untuk penggunaan ringan, browsing, dan sosial media. 1-3 Perangkat.',
                'is_active'  => true,
            ],
            [
                'nama_paket' => 'Paket Keluarga 30 Mbps',
                'harga'      => 250000.00,
                'deskripsi'  => 'Ideal untuk streaming Youtube/Netflix HD dan Zoom Meeting. 4-6 Perangkat.',
                'is_active'  => true,
            ],
            [
                'nama_paket' => 'Paket Gamer 50 Mbps',
                'harga'      => 375000.00,
                'deskripsi'  => 'Prioritas latency rendah (low ping) dan upload simetris. Stabil untuk gaming.',
                'is_active'  => true,
            ],
            [
                'nama_paket' => 'Paket Sultan 100 Mbps',
                'harga'      => 650000.00,
                'deskripsi'  => 'Kecepatan maksimal tanpa buffer untuk 4K streaming dan smart home. 10+ Perangkat.',
                'is_active'  => true,
            ],
            // Contoh paket non-aktif (Misal paket promo lama)
            [
                'nama_paket' => 'Paket Promo Merdeka (Discontinued)',
                'harga'      => 100000.00,
                'deskripsi'  => 'Promo khusus bulan Agustus.',
                'is_active'  => false,
            ],
        ];

        foreach ($pakets as $paket) {
            PaketLayanan::create($paket);
        }
    }
}