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
        Schema::create('dokumen_siswa', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->unsignedBigInteger('id_calon_siswa');
            $table->unsignedBigInteger('id_jenis_dokumen');
            $table->string('nama_file', 255);
            $table->string('file_path', 255);
            $table->string('tipe_file', 50)->nullable(); // pdf, jpg, png, dll.
            $table->integer('ukuran_file')->nullable(); // Dalam KB
            $table->enum('status_verifikasi', ['menunggu', 'valid', 'ditolak'])->default('menunggu');
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->foreign('id_calon_siswa')->references('id_calon_siswa')->on('calon_siswa')->cascadeOnDelete();
            $table->foreign('id_jenis_dokumen')->references('id_jenis_dokumen')->on('ref_jenis_dokumen')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_siswa');
    }
};
