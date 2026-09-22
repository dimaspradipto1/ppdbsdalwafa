<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jalur', function (Blueprint $table) {
            $table->id('id_jalur');
            $table->foreignId('id_tahun_ajaran')->nullable()->constrained('tahun_ajaran', 'id_tahun_ajaran')->nullOnDelete();
            $table->string('nama_jalur', 100);
            $table->string('kode_jalur', 50)->unique()->nullable();
            $table->integer('kuota')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan_khusus')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jalur');
    }
};
