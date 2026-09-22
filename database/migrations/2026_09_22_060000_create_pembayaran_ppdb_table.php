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
        Schema::create('pembayaran_ppdb', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_calon_siswa');
            $table->unsignedBigInteger('id_biaya')->nullable();
            $table->string('kode_transaksi', 50)->unique();
            $table->decimal('nominal', 12, 2);
            $table->string('metode_pembayaran', 50)->default('Transfer Bank'); // Transfer Bank, Tunai / Kasir
            $table->string('nama_bank_pengirim', 100)->nullable();
            $table->string('nomor_rekening_pengirim', 50)->nullable();
            $table->string('atas_nama_pengirim', 150)->nullable();
            $table->string('bukti_transfer', 255)->nullable();
            $table->enum('status_pembayaran', ['menunggu_konfirmasi', 'lunas', 'ditolak'])->default('menunggu_konfirmasi');
            $table->text('catatan')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->dateTime('tanggal_bayar')->useCurrent();
            $table->timestamps();

            $table->foreign('id_calon_siswa')->references('id_calon_siswa')->on('calon_siswa')->cascadeOnDelete();
            $table->foreign('id_biaya')->references('id_biaya')->on('biaya_ppdb')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_ppdb');
    }
};
