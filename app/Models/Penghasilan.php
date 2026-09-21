<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghasilan extends Model
{
    use HasFactory;

    protected $table = 'ref_penghasilan';

    protected $primaryKey = 'id_penghasilan';

    protected $fillable = [
        'label',
        'batas_bawah',
        'batas_atas',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'batas_bawah' => 'decimal:2',
        'batas_atas'  => 'decimal:2',
        'urutan'      => 'integer',
        'is_active'   => 'boolean',
    ];

    /**
     * Format rentang nominal rupiah yang informatif
     */
    public function getRentangFormatAttribute(): string
    {
        if ($this->batas_bawah === null && $this->batas_atas === null) {
            return '-';
        }

        if ($this->batas_bawah !== null && $this->batas_atas === null) {
            return '> Rp ' . number_format($this->batas_bawah, 0, ',', '.');
        }

        if ($this->batas_bawah === null && $this->batas_atas !== null) {
            return '< Rp ' . number_format($this->batas_atas, 0, ',', '.');
        }

        if ($this->batas_bawah == 0 && $this->batas_atas == 0) {
            return 'Rp 0';
        }

        return 'Rp ' . number_format($this->batas_bawah, 0, ',', '.') . ' - Rp ' . number_format($this->batas_atas, 0, ',', '.');
    }
}
