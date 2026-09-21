<?php

namespace Database\Seeders;

use App\Models\Penghasilan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenghasilanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarPenghasilan = [
            [
                'label'       => 'Tidak Berpenghasilan',
                'batas_bawah' => 0,
                'batas_atas'  => 0,
                'urutan'      => 1,
                'is_active'   => true,
            ],
            [
                'label'       => 'Kurang dari Rp 500.000',
                'batas_bawah' => 0,
                'batas_atas'  => 499999,
                'urutan'      => 2,
                'is_active'   => true,
            ],
            [
                'label'       => 'Rp 500.000 - Rp 999.999',
                'batas_bawah' => 500000,
                'batas_atas'  => 999999,
                'urutan'      => 3,
                'is_active'   => true,
            ],
            [
                'label'       => 'Rp 1.000.000 - Rp 1.999.999',
                'batas_bawah' => 1000000,
                'batas_atas'  => 1999999,
                'urutan'      => 4,
                'is_active'   => true,
            ],
            [
                'label'       => 'Rp 2.000.000 - Rp 4.999.999',
                'batas_bawah' => 2000000,
                'batas_atas'  => 4999999,
                'urutan'      => 5,
                'is_active'   => true,
            ],
            [
                'label'       => 'Rp 5.000.000 - Rp 20.000.000',
                'batas_bawah' => 5000000,
                'batas_atas'  => 20000000,
                'urutan'      => 6,
                'is_active'   => true,
            ],
            [
                'label'       => 'Lebih dari Rp 20.000.000',
                'batas_bawah' => 20000001,
                'batas_atas'  => null,
                'urutan'      => 7,
                'is_active'   => true,
            ],
        ];

        foreach ($daftarPenghasilan as $item) {
            Penghasilan::updateOrCreate(
                ['label' => $item['label']],
                [
                    'batas_bawah' => $item['batas_bawah'],
                    'batas_atas'  => $item['batas_atas'],
                    'urutan'      => $item['urutan'],
                    'is_active'   => $item['is_active'],
                ]
            );
        }
    }
}
