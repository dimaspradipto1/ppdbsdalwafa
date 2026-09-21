<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarAgama = [
            [
                'nama_agama' => 'Islam',
                'keterangan' => 'Agama Islam',
                'is_active'  => true,
            ],
            [
                'nama_agama' => 'Kristen',
                'keterangan' => 'Kristen Protestan',
                'is_active'  => true,
            ],
            [
                'nama_agama' => 'Katolik',
                'keterangan' => 'Kristen Katolik',
                'is_active'  => true,
            ],
            [
                'nama_agama' => 'Hindu',
                'keterangan' => 'Agama Hindu',
                'is_active'  => true,
            ],
            [
                'nama_agama' => 'Buddha',
                'keterangan' => 'Agama Buddha',
                'is_active'  => true,
            ],
            [
                'nama_agama' => 'Khonghucu',
                'keterangan' => 'Agama Khonghucu',
                'is_active'  => true,
            ],
        ];

        foreach ($daftarAgama as $item) {
            Agama::updateOrCreate(
                ['nama_agama' => $item['nama_agama']],
                [
                    'keterangan' => $item['keterangan'],
                    'is_active'  => $item['is_active'],
                ]
            );
        }
    }
}
