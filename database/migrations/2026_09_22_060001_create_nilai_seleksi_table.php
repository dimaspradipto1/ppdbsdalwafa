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
        Schema::create('nilai_seleksi', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->unsignedBigInteger('id_calon_siswa');
            $table->unsignedBigInteger('id_komponen_seleksi');
            $table->decimal('nilai', 5, 2)->default(0.00);
            $table->string('catatan', 255)->nullable();
            $table->foreignId('penguji_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('id_calon_siswa')->references('id_calon_siswa')->on('calon_siswa')->cascadeOnDelete();
            $table->foreign('id_komponen_seleksi')->references('id_komponen_seleksi')->on('komponen_seleksi')->cascadeOnDelete();

            $table->unique(['id_calon_siswa', 'id_komponen_seleksi'], 'unique_siswa_komponen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_seleksi');
    }
};
