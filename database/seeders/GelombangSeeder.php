<?php

namespace Database\Seeders;

use App\Models\Gelombang;
use App\Models\TahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GelombangSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::where('is_active', true)->first() ?? TahunAjaran::first();

        $daftarGelombang = [
            [
                'id_tahun_ajaran' => optional($tahunAjaran)->id_tahun_ajaran,
                'nama_gelombang'  => 'Gelombang 1 (Indent / Early Bird)',
                'tanggal_mulai'   => '2026-10-01',
                'tanggal_selesai' => '2026-12-31',
                'kuota'           => 60,
                'is_active'       => true,
                'keterangan'      => 'Pendaftaran gelombang khusus dengan diskon uang pangkal',
            ],
            [
                'id_tahun_ajaran' => optional($tahunAjaran)->id_tahun_ajaran,
                'nama_gelombang'  => 'Gelombang 2 (Reguler)',
                'tanggal_mulai'   => '2027-01-01',
                'tanggal_selesai' => '2027-04-30',
                'kuota'           => 60,
                'is_active'       => false,
                'keterangan'      => 'Pendaftaran jalur reguler',
            ],
        ];

        foreach ($daftarGelombang as $item) {
            Gelombang::updateOrCreate(
                [
                    'id_tahun_ajaran' => $item['id_tahun_ajaran'],
                    'nama_gelombang'  => $item['nama_gelombang'],
                ],
                [
                    'tanggal_mulai'   => $item['tanggal_mulai'],
                    'tanggal_selesai' => $item['tanggal_selesai'],
                    'kuota'           => $item['kuota'],
                    'is_active'       => $item['is_active'],
                    'keterangan'      => $item['keterangan'],
                ]
            );
        }
    }
}
