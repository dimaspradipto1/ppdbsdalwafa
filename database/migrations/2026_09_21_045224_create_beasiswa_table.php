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
        Schema::create('beasiswa', function (Blueprint $table) {
            $table->id('id_beasiswa');
            $table->unsignedBigInteger('id_calon_siswa');
            $table->string('jenis_beasiswa', 100);
            $table->string('penyelenggara', 150);
            $table->string('tahun_mulai', 4);
            $table->string('tahun_selesai', 4)->nullable();
            $table->timestamps();

            $table->foreign('id_calon_siswa')->references('id_calon_siswa')->on('calon_siswa')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswa');
    }
};
