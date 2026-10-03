<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageBanner extends Model
{
    use HasFactory;

    protected $table = 'homepage_banners';

    protected $fillable = [
        'judul',
        'subjudul',
        'badge_text',
        'gambar',
        'tombol_text_1',
        'tombol_link_1',
        'tombol_text_2',
        'tombol_link_2',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar && file_exists(public_path($this->gambar))) {
            return asset($this->gambar);
        }
        if ($this->gambar && str_starts_with($this->gambar, 'http')) {
            return $this->gambar;
        }
        return asset('assets/img/school-banner.jpg');
    }
}
