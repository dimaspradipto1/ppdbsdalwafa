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
                'kode'       => 'A',
                'nama'       => 'Tidak Ada',
                'keterangan' => 'Siswa tidak memiliki kebutuhan khusus',
                'is_active'  => true,
            ],
            [
                'kode'       => 'B',
                'nama'       => 'Netra',
                'keterangan' => 'Gangguan penglihatan / buta total atau low vision',
                'is_active'  => true,
            ],
            [
                'kode'       => 'C',
                'nama'       => 'Rungu',
                'keterangan' => 'Gangguan pendengaran',
                'is_active'  => true,
            ],
            [
                'kode'       => 'D',
                'nama'       => 'Grahita',
                'keterangan' => 'Hambatan intelektual / kecerdasan di bawah rata-rata',
                'is_active'  => true,
            ],
            [
                'kode'       => 'E',
                'nama'       => 'Daksa',
                'keterangan' => 'Gangguan fungsi anggota tubuh / fisik gerak',
                'is_active'  => true,
            ],
            [
                'kode'       => 'F',
                'nama'       => 'Laras',
                'keterangan' => 'Gangguan emosi dan perilaku',
                'is_active'  => true,
            ],
            [
                'kode'       => 'G',
                'nama'       => 'Wicara',
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
                'kode'       => 'L',
                'nama'       => 'Down Syndrome',
                'keterangan' => 'Kelainan genetik kromosom 21',
                'is_active'  => true,
            ],
            [
                'kode'       => 'M',
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
