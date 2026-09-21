<?php

namespace Database\Seeders;

use App\Models\Pendidikan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendidikanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarPendidikan = [
            [
                'nama_pendidikan' => 'Tidak / Belum Sekolah',
                'keterangan'      => 'Tidak atau belum pernah mengenyam pendidikan formal',
                'is_active'       => true,
            ],
            [
                'nama_pendidikan' => 'PAUD / TK',
                'keterangan'      => 'Pendidikan Anak Usia Dini / Taman Kanak-kanak',
                'is_active'       => true,
            ],
            [
                'nama_pendidikan' => 'SD / Sederajat',
                'keterangan'      => 'Sekolah Dasar / Madrasah Ibtidaiyah',
                'is_active'       => true,
            ],
            [
                'nama_pendidikan' => 'SMP / Sederajat',
                'keterangan'      => 'Sekolah Menengah Pertama / Madrasah Tsanawiyah',
                'is_active'       => true,
            ],
            [
                'nama_pendidikan' => 'SMA / SMK / Sederajat',
                'keterangan'      => 'Sekolah Menengah Atas / Kejuruan / Madrasah Aliyah',
                'is_active'       => true,
            ],
            [
                'nama_pendidikan' => 'D1 / D2 / D3',
                'keterangan'      => 'Diploma Satu / Dua / Tiga',
                'is_active'       => true,
            ],
            [
                'nama_pendidikan' => 'D4 / S1 (Sarjana)',
                'keterangan'      => 'Diploma Empat / Strata Satu',
                'is_active'       => true,
            ],
            [
                'nama_pendidikan' => 'S2 (Magister)',
                'keterangan'      => 'Strata Dua / Magister',
                'is_active'       => true,
            ],
            [
                'nama_pendidikan' => 'S3 (Doktor)',
                'keterangan'      => 'Strata Tiga / Doktor',
                'is_active'       => true,
            ],
        ];

        foreach ($daftarPendidikan as $item) {
            Pendidikan::updateOrCreate(
                ['nama_pendidikan' => $item['nama_pendidikan']],
                [
                    'keterangan' => $item['keterangan'],
                    'is_active'  => $item['is_active'],
                ]
            );
        }
    }
}
