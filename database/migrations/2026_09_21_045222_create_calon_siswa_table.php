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
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id('id_calon_siswa');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // 1. IDENTITAS PESERTA DIDIK
            $table->string('nama_lengkap', 150);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nik', 16)->nullable();
            $table->string('nisn', 10)->nullable();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->unsignedBigInteger('id_agama')->nullable();
            $table->integer('jumlah_saudara_kandung')->default(0);
            $table->integer('anak_ke')->default(1);
            $table->unsignedBigInteger('id_kebutuhan_khusus')->nullable();

            // Alamat Tempat Tinggal
            $table->string('alamat_jalan', 255)->nullable(); // Dusun / JL
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten_kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('alat_transportasi', 100)->nullable();
            $table->string('jenis_tinggal', 100)->nullable(); // Bersama Orangtua / Wali / Kost / Asrama / Panti Asuhan / Dll
            $table->string('telepon_rumah', 20)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('jarak_ke_sekolah', 50)->nullable(); // kurang 1 km / lebih dari 1 km
            $table->string('jarak_ke_sekolah_detail', 50)->nullable(); // detail jika > 1 km
            $table->string('waktu_tempuh', 50)->nullable(); // kurang dari 30 menit / 30-60 menit / lebih dari 60 menit
            $table->string('email', 100)->nullable();
            $table->string('asal_sekolah', 150)->nullable(); // TK

            // 2. DATA AYAH KANDUNG
            $table->string('nama_ayah', 150)->nullable();
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->unsignedBigInteger('pekerjaan_ayah_id')->nullable();
            $table->unsignedBigInteger('pendidikan_ayah_id')->nullable();
            $table->unsignedBigInteger('agama_ayah_id')->nullable();
            $table->unsignedBigInteger('penghasilan_ayah_id')->nullable();

            // 3. DATA IBU KANDUNG
            $table->string('nama_ibu', 150)->nullable();
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->unsignedBigInteger('pekerjaan_ibu_id')->nullable();
            $table->unsignedBigInteger('pendidikan_ibu_id')->nullable();
            $table->unsignedBigInteger('agama_ibu_id')->nullable();
            $table->unsignedBigInteger('penghasilan_ibu_id')->nullable();

            // 4. DATA WALI
            $table->string('nama_wali', 150)->nullable();
            $table->string('tempat_lahir_wali', 100)->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->unsignedBigInteger('pekerjaan_wali_id')->nullable();
            $table->unsignedBigInteger('pendidikan_wali_id')->nullable();
            $table->unsignedBigInteger('agama_wali_id')->nullable();
            $table->unsignedBigInteger('penghasilan_wali_id')->nullable();

            // Status Pendaftaran
            $table->enum('status', ['draft', 'menunggu_verifikasi', 'diverifikasi', 'diterima', 'ditolak'])->default('menunggu_verifikasi');

            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('id_agama')->references('id_agama')->on('agama')->nullOnDelete();
            $table->foreign('id_kebutuhan_khusus')->references('id_kebutuhan')->on('ref_kebutuhan_khusus')->nullOnDelete();

            $table->foreign('pekerjaan_ayah_id')->references('id_pekerjaan')->on('pekerjaan')->nullOnDelete();
            $table->foreign('pendidikan_ayah_id')->references('id_pendidikan')->on('pendidikan')->nullOnDelete();
            $table->foreign('agama_ayah_id')->references('id_agama')->on('agama')->nullOnDelete();
            $table->foreign('penghasilan_ayah_id')->references('id_penghasilan')->on('ref_penghasilan')->nullOnDelete();

            $table->foreign('pekerjaan_ibu_id')->references('id_pekerjaan')->on('pekerjaan')->nullOnDelete();
            $table->foreign('pendidikan_ibu_id')->references('id_pendidikan')->on('pendidikan')->nullOnDelete();
            $table->foreign('agama_ibu_id')->references('id_agama')->on('agama')->nullOnDelete();
            $table->foreign('penghasilan_ibu_id')->references('id_penghasilan')->on('ref_penghasilan')->nullOnDelete();

            $table->foreign('pekerjaan_wali_id')->references('id_pekerjaan')->on('pekerjaan')->nullOnDelete();
            $table->foreign('pendidikan_wali_id')->references('id_pendidikan')->on('pendidikan')->nullOnDelete();
            $table->foreign('agama_wali_id')->references('id_agama')->on('agama')->nullOnDelete();
            $table->foreign('penghasilan_wali_id')->references('id_penghasilan')->on('ref_penghasilan')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};
