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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');
            $table->unsignedBigInteger('id_calon_siswa');
            $table->string('jenis_prestasi', 50);
            $table->string('tingkat', 50);
            $table->string('nama_prestasi', 150);
            $table->string('tahun', 4);
            $table->string('penyelenggara', 150);
            $table->timestamps();

            $table->foreign('id_calon_siswa')->references('id_calon_siswa')->on('calon_siswa')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
