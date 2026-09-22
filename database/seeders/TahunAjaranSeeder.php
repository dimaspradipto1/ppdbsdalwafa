<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarTahunAjaran = [
            [
                'tahun_ajaran'      => '2024/2025',
                'nama_tahun_ajaran' => 'Tahun Ajaran 2024/2025',
                'tanggal_mulai'     => '2024-07-01',
                'tanggal_selesai'   => '2025-06-30',
                'is_active'         => false,
                'keterangan'        => 'Tahun ajaran sebelumnya',
            ],
            [
                'tahun_ajaran'      => '2025/2026',
                'nama_tahun_ajaran' => 'Tahun Ajaran 2025/2026',
                'tanggal_mulai'     => '2025-07-01',
                'tanggal_selesai'   => '2026-06-30',
                'is_active'         => false,
                'keterangan'        => 'Tahun ajaran berjalan',
            ],
            [
                'tahun_ajaran'      => '2026/2027',
                'nama_tahun_ajaran' => 'Tahun Ajaran 2026/2027',
                'tanggal_mulai'     => '2026-07-01',
                'tanggal_selesai'   => '2027-06-30',
                'is_active'         => true,
                'keterangan'        => 'Tahun ajaran PPDB aktif saat ini',
            ],
        ];

        foreach ($daftarTahunAjaran as $item) {
            TahunAjaran::updateOrCreate(
                ['tahun_ajaran' => $item['tahun_ajaran']],
                [
                    'nama_tahun_ajaran' => $item['nama_tahun_ajaran'],
                    'tanggal_mulai'     => $item['tanggal_mulai'],
                    'tanggal_selesai'   => $item['tanggal_selesai'],
                    'is_active'         => $item['is_active'],
                    'keterangan'        => $item['keterangan'],
                ]
            );
        }
    }
}
