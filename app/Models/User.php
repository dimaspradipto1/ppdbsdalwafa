<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLES = [
        'super_admin'    => 'Super Admin',
        'admin_ppdb'     => 'Admin PPDB',
        'verifikator'    => 'Panitia Verifikasi',
        'kepala_sekolah' => 'Kepala Sekolah',
        'bendahara'      => 'Bendahara',
        'guru'           => 'Guru / Wali Kelas',
        'pendaftar'      => 'Calon Siswa / Orang Tua',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Cek apakah user memiliki salah satu dari role yang ditentukan
     */
    public function hasRole(...$roles): bool
    {
        if (in_array('*', $roles)) {
            return true;
        }

        return in_array($this->role, $roles);
    }
}
