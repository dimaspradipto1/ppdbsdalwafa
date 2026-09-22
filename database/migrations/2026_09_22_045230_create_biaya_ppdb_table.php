<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biaya_ppdb', function (Blueprint $table) {
            $table->id('id_biaya');
            $table->foreignId('id_tahun_ajaran')->nullable()->constrained('tahun_ajaran', 'id_tahun_ajaran')->nullOnDelete();
            $table->foreignId('id_gelombang')->nullable()->constrained('gelombang', 'id_gelombang')->nullOnDelete();
            $table->foreignId('id_jalur')->nullable()->constrained('jalur', 'id_jalur')->nullOnDelete();
            $table->string('nama_biaya', 150);
            $table->string('jenis_biaya', 50)->default('lainnya');
            $table->decimal('nominal', 14, 2)->default(0);
            $table->string('tipe_pembayaran', 50)->default('sekali_bayar');
            $table->boolean('is_wajib')->default(true);
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya_ppdb');
    }
};
