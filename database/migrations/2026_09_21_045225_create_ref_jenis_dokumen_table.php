<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ref_jenis_dokumen', function (Blueprint $table) {
            $table->id('id_jenis_dokumen');
            $table->string('kode', 50)->unique();
            $table->string('nama_dokumen', 150);
            $table->enum('kategori', ['semua', 'siswa_baru', 'siswa_pindahan'])->default('semua');
            $table->string('jumlah_lembar', 100)->nullable(); // contoh: "3 lembar", "1 lembar masing-masing"
            $table->string('keterangan', 255)->nullable(); // contoh: "Seragam Putih SD latar belakang merah"
            $table->boolean('is_wajib')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_jenis_dokumen');
    }
};
