<?php

namespace Database\Seeders;

use App\Models\KebutuhanKhusus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KebutuhanKhususSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarKebutuhan = [
            [
                'kode'       => '01',
                'nama'       => 'Tidak Ada',
                'keterangan' => 'Siswa tidak memiliki kebutuhan khusus',
                'is_active'  => true,
            ],
            [
                'kode'       => 'A',
                'nama'       => 'Netra (A)',
                'keterangan' => 'Gangguan penglihatan / buta total atau low vision',
                'is_active'  => true,
            ],
            [
                'kode'       => 'B',
                'nama'       => 'Rungu (B)',
                'keterangan' => 'Gangguan pendengaran',
                'is_active'  => true,
            ],
            [
                'kode'       => 'C',
                'nama'       => 'Grahita Ringan (C)',
                'keterangan' => 'Hambatan intelektual ringan (IQ 50-70)',
                'is_active'  => true,
            ],
            [
                'kode'       => 'C1',
                'nama'       => 'Grahita Sedang (C1)',
                'keterangan' => 'Hambatan intelektual sedang (IQ 35-49)',
                'is_active'  => true,
            ],
            [
                'kode'       => 'D',
                'nama'       => 'Daksa Ringan (D)',
                'keterangan' => 'Gangguan fungsi anggota tubuh / fisik ringan',
                'is_active'  => true,
            ],
            [
                'kode'       => 'D1',
                'nama'       => 'Daksa Sedang (D1)',
                'keterangan' => 'Gangguan gerak anggota tubuh sedang',
                'is_active'  => true,
            ],
            [
                'kode'       => 'E',
                'nama'       => 'Laras (E)',
                'keterangan' => 'Gangguan emosi dan perilaku',
                'is_active'  => true,
            ],
            [
                'kode'       => 'F',
                'nama'       => 'Wicara (F)',
                'keterangan' => 'Gangguan komunikasi dan wicara',
                'is_active'  => true,
            ],
            [
                'kode'       => 'H',
                'nama'       => 'Hiperaktif (ADHD)',
                'keterangan' => 'Attention Deficit Hyperactivity Disorder',
                'is_active'  => true,
            ],
            [
                'kode'       => 'I',
                'nama'       => 'Cerdas Istimewa (Gifted)',
                'keterangan' => 'Potensi kecerdasan istimewa / IQ tinggi',
                'is_active'  => true,
            ],
            [
                'kode'       => 'J',
                'nama'       => 'Bakat Istimewa (Talented)',
                'keterangan' => 'Potensi bakat istimewa khusus',
                'is_active'  => true,
            ],
            [
                'kode'       => 'K',
                'nama'       => 'Tuna Ganda',
                'keterangan' => 'Memiliki lebih dari satu jenis kebutuhan khusus',
                'is_active'  => true,
            ],
            [
                'kode'       => 'P',
                'nama'       => 'Down Syndrome',
                'keterangan' => 'Kelainan genetik kromosom 21',
                'is_active'  => true,
            ],
            [
                'kode'       => 'Q',
                'nama'       => 'Autis',
                'keterangan' => 'Gangguan perkembangan spektrum autisme',
                'is_active'  => true,
            ],
        ];

        foreach ($daftarKebutuhan as $item) {
            KebutuhanKhusus::updateOrCreate(
                ['kode' => $item['kode']],
                [
                    'nama'       => $item['nama'],
                    'keterangan' => $item['keterangan'],
                    'is_active'  => $item['is_active'],
                ]
            );
        }
    }
}
