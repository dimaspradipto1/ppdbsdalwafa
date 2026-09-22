<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komponen_seleksi', function (Blueprint $table) {
            $table->id('id_komponen_seleksi');
            $table->string('nama_komponen', 150);
            $table->string('kode', 50)->nullable();
            $table->decimal('nilai_minimal', 5, 2)->nullable()->default(70.00);
            $table->integer('bobot_persen')->nullable()->default(0);
            $table->integer('urutan')->default(1);
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komponen_seleksi');
    }
};
