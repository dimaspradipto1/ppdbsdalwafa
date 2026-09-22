<?php

namespace Database\Seeders;

use App\Models\Biaya;
use App\Models\TahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BiayaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $ta = TahunAjaran::where('is_active', true)->first() ?? TahunAjaran::first();

        $daftarBiaya = [
            [
                'id_tahun_ajaran' => optional($ta)->id_tahun_ajaran,
                'nama_biaya'      => 'Biaya Formulir & Pendaftaran',
                'jenis_biaya'     => 'pendaftaran',
                'nominal'         => 250000,
                'tipe_pembayaran' => 'sekali_bayar',
                'is_wajib'        => true,
                'is_active'       => true,
                'keterangan'      => 'Biaya pembelian formulir dan administrasi pendaftaran awal',
            ],
            [
                'id_tahun_ajaran' => optional($ta)->id_tahun_ajaran,
                'nama_biaya'      => 'Uang Pangkal / Masuk (Gelombang 1)',
                'jenis_biaya'     => 'uang_pangkal',
                'nominal'         => 5000000,
                'tipe_pembayaran' => 'sekali_bayar',
                'is_wajib'        => true,
                'is_active'       => true,
                'keterangan'      => 'Biaya pembangunan dan fasilitas sekolah gelombang indent',
            ],
            [
                'id_tahun_ajaran' => optional($ta)->id_tahun_ajaran,
                'nama_biaya'      => 'SPP Bulanan (Bulan Juli)',
                'jenis_biaya'     => 'spp',
                'nominal'         => 500000,
                'tipe_pembayaran' => 'bulanan',
                'is_wajib'        => true,
                'is_active'       => true,
                'keterangan'      => 'SPP wajib dibayar sebelum tanggal 10 setiap bulannya (denda Rp 10.000/hari)',
            ],
            [
                'id_tahun_ajaran' => optional($ta)->id_tahun_ajaran,
                'nama_biaya'      => 'Paket Seragam Sekolah Lengkap',
                'jenis_biaya'     => 'seragam',
                'nominal'         => 1200000,
                'tipe_pembayaran' => 'sekali_bayar',
                'is_wajib'        => true,
                'is_active'       => true,
                'keterangan'      => 'Seragam Merah Putih, Batik, Muslim, Pramuka, dan Olahraga',
            ],
            [
                'id_tahun_ajaran' => optional($ta)->id_tahun_ajaran,
                'nama_biaya'      => 'Buku Paket Pembelajaran & Modul',
                'jenis_biaya'     => 'buku',
                'nominal'         => 850000,
                'tipe_pembayaran' => 'sekali_bayar',
                'is_wajib'        => true,
                'is_active'       => true,
                'keterangan'      => 'Buku kurikulum nasional dan modul pendidikan Islam terpadu',
            ],
        ];

        foreach ($daftarBiaya as $item) {
            Biaya::updateOrCreate(
                [
                    'id_tahun_ajaran' => $item['id_tahun_ajaran'],
                    'nama_biaya'      => $item['nama_biaya'],
                ],
                $item
            );
        }
    }
}
