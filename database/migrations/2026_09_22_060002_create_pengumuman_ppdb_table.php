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
        Schema::create('pengumuman_ppdb', function (Blueprint $table) {
            $table->id('id_pengumuman');
            $table->unsignedBigInteger('id_tahun_ajaran')->nullable();
            $table->unsignedBigInteger('id_gelombang')->nullable();
            $table->string('judul', 200);
            $table->string('nomor_surat', 100)->nullable();
            $table->dateTime('tanggal_buka')->useCurrent();
            $table->text('isi_pengumuman')->nullable();
            $table->string('file_lampiran', 255)->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran')->nullOnDelete();
            $table->foreign('id_gelombang')->references('id_gelombang')->on('gelombang')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman_ppdb');
    }
};
