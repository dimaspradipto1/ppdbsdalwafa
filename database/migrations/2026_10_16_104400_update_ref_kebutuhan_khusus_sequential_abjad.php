<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function () {
            // Temporary prefix to avoid unique constraint violations on 'kode'
            DB::table('ref_kebutuhan_khusus')->update([
                'kode' => DB::raw("CONCAT('TEMP_', id_kebutuhan)")
            ]);

            // Remap foreign keys if any student used sub categories C1 (id=5) or D1 (id=7)
            DB::table('calon_siswa')->where('id_kebutuhan_khusus', 5)->update(['id_kebutuhan_khusus' => 4]);
            DB::table('calon_siswa')->where('id_kebutuhan_khusus', 7)->update(['id_kebutuhan_khusus' => 6]);

            // Delete sub categories C1 and D1
            DB::table('ref_kebutuhan_khusus')->whereIn('id_kebutuhan', [5, 7])->delete();

            // Set sequential abjad A - M
            $updates = [
                1  => ['kode' => 'A', 'nama' => 'Tidak Ada', 'keterangan' => 'Siswa tidak memiliki kebutuhan khusus'],
                2  => ['kode' => 'B', 'nama' => 'Netra', 'keterangan' => 'Gangguan penglihatan / buta total atau low vision'],
                3  => ['kode' => 'C', 'nama' => 'Rungu', 'keterangan' => 'Gangguan pendengaran'],
                4  => ['kode' => 'D', 'nama' => 'Grahita', 'keterangan' => 'Hambatan intelektual / kecerdasan di bawah rata-rata'],
                6  => ['kode' => 'E', 'nama' => 'Daksa', 'keterangan' => 'Gangguan fungsi anggota tubuh / fisik gerak'],
                8  => ['kode' => 'F', 'nama' => 'Laras', 'keterangan' => 'Gangguan emosi dan perilaku'],
                9  => ['kode' => 'G', 'nama' => 'Wicara', 'keterangan' => 'Gangguan komunikasi dan wicara'],
                10 => ['kode' => 'H', 'nama' => 'Hiperaktif (ADHD)', 'keterangan' => 'Attention Deficit Hyperactivity Disorder'],
                11 => ['kode' => 'I', 'nama' => 'Cerdas Istimewa (Gifted)', 'keterangan' => 'Potensi kecerdasan istimewa / IQ tinggi'],
                12 => ['kode' => 'J', 'nama' => 'Bakat Istimewa (Talented)', 'keterangan' => 'Potensi bakat istimewa khusus'],
                13 => ['kode' => 'K', 'nama' => 'Tuna Ganda', 'keterangan' => 'Memiliki lebih dari satu jenis kebutuhan khusus'],
                14 => ['kode' => 'L', 'nama' => 'Down Syndrome', 'keterangan' => 'Kelainan genetik kromosom 21'],
                15 => ['kode' => 'M', 'nama' => 'Autis', 'keterangan' => 'Gangguan perkembangan spektrum autisme'],
            ];

            foreach ($updates as $id => $data) {
                DB::table('ref_kebutuhan_khusus')->where('id_kebutuhan', $id)->update($data);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
