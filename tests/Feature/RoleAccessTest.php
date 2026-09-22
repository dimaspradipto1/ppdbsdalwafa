<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    private function getUserWithRole(string $role): User
    {
        return User::firstOrCreate(
            ['email' => "user_{$role}@gmail.com"],
            [
                'name'     => "User {$role}",
                'password' => Hash::make('password'),
                'role'     => $role,
            ]
        );
    }

    public function test_pendaftar_cannot_access_restricted_modules(): void
    {
        $pendaftar = $this->getUserWithRole('pendaftar');

        // Pendaftar dilarang akses manajemen user
        $this->actingAs($pendaftar)->get(route('users.index'))->assertStatus(403);

        // Pendaftar dilarang akses master biaya
        $this->actingAs($pendaftar)->get(route('biaya.index'))->assertStatus(403);

        // Pendaftar dilarang akses penilaian seleksi
        $this->actingAs($pendaftar)->get(route('nilai-seleksi.index'))->assertStatus(403);

        // Pendaftar dilarang membuat pengumuman
        $this->actingAs($pendaftar)->get(route('pengumuman.create'))->assertStatus(403);
    }

    public function test_bendahara_access_boundaries(): void
    {
        $bendahara = $this->getUserWithRole('bendahara');

        // Bendahara dapat mengakses tarif & biaya serta pembayaran
        $this->actingAs($bendahara)->get(route('biaya.index'))->assertStatus(200);
        $this->actingAs($bendahara)->get(route('pembayaran.index'))->assertStatus(200);

        // Bendahara dilarang mengakses manajemen users dan penilaian seleksi
        $this->actingAs($bendahara)->get(route('users.index'))->assertStatus(403);
        $this->actingAs($bendahara)->get(route('nilai-seleksi.index'))->assertStatus(403);
    }

    public function test_guru_access_boundaries(): void
    {
        $guru = $this->getUserWithRole('guru');

        // Guru dapat mengakses lembar penilaian seleksi
        $this->actingAs($guru)->get(route('nilai-seleksi.index'))->assertStatus(200);

        // Guru dilarang mengakses pembayaran dan master biaya
        $this->actingAs($guru)->get(route('pembayaran.index'))->assertStatus(403);
        $this->actingAs($guru)->get(route('biaya.index'))->assertStatus(403);
    }

    public function test_verifikator_access_boundaries(): void
    {
        $verifikator = $this->getUserWithRole('verifikator');

        // Verifikator dapat mengakses pendaftaran dan dokumen
        $this->actingAs($verifikator)->get(route('calon-siswa.index'))->assertStatus(200);
        $this->actingAs($verifikator)->get(route('dokumen.index'))->assertStatus(200);

        // Verifikator dilarang mengakses transaksi pembayaran dan master biaya
        $this->actingAs($verifikator)->get(route('pembayaran.index'))->assertStatus(403);
        $this->actingAs($verifikator)->get(route('biaya.index'))->assertStatus(403);
    }

    public function test_kepala_sekolah_access_boundaries(): void
    {
        $kepsek = $this->getUserWithRole('kepala_sekolah');

        // Kepala sekolah dapat mengakses profil sekolah, seleksi, dan pengumuman
        $this->actingAs($kepsek)->get(route('sekolah.index'))->assertStatus(200);
        $this->actingAs($kepsek)->get(route('nilai-seleksi.index'))->assertStatus(200);
        $this->actingAs($kepsek)->get(route('pengumuman.index'))->assertStatus(200);

        // Kepala sekolah dilarang mengakses manajemen user (khusus super admin)
        $this->actingAs($kepsek)->get(route('users.index'))->assertStatus(403);
    }
}
