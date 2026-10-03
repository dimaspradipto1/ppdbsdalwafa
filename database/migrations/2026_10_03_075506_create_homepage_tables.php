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
        Schema::create('homepage_banners', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('subjudul')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('gambar')->nullable();
            $table->string('tombol_text_1')->nullable()->default('Daftar Sekarang');
            $table->string('tombol_link_1')->nullable()->default('/register');
            $table->string('tombol_text_2')->nullable()->default('Alur & Biaya');
            $table->string('tombol_link_2')->nullable()->default('#alur');
            $table->integer('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('label')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function upDown(): void
    {
        Schema::dropIfExists('homepage_settings');
        Schema::dropIfExists('homepage_banners');
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
        Schema::dropIfExists('homepage_banners');
    }
};
