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
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->string('no_pendaftaran', 50)->nullable()->unique()->after('id_calon_siswa');
            $table->unsignedBigInteger('id_tahun_ajaran')->nullable()->after('user_id');
            $table->unsignedBigInteger('id_gelombang')->nullable()->after('id_tahun_ajaran');
            $table->unsignedBigInteger('id_jalur')->nullable()->after('id_gelombang');
            $table->timestamp('tanggal_daftar')->nullable()->after('status');
            $table->text('catatan_verifikasi')->nullable()->after('tanggal_daftar');
            $table->foreignId('verified_by')->nullable()->after('catatan_verifikasi')->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable()->after('verified_by');

            // Foreign Key Constraints
            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran')->nullOnDelete();
            $table->foreign('id_gelombang')->references('id_gelombang')->on('gelombang')->nullOnDelete();
            $table->foreign('id_jalur')->references('id_jalur')->on('jalur')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->dropForeign(['id_tahun_ajaran']);
            $table->dropForeign(['id_gelombang']);
            $table->dropForeign(['id_jalur']);
            $table->dropForeign(['verified_by']);

            $table->dropColumn([
                'no_pendaftaran',
                'id_tahun_ajaran',
                'id_gelombang',
                'id_jalur',
                'tanggal_daftar',
                'catatan_verifikasi',
                'verified_by',
                'verified_at',
            ]);
        });
    }
};
