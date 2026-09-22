<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\KomponenSeleksi;
use App\Models\NilaiSeleksi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class NilaiSeleksiTest extends TestCase
{
    private function getSuperAdmin(): User
    {
        return User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
                'role'     => 'super_admin',
            ]
        );
    }

    private function getOrCreateCalonSiswa(): CalonSiswa
    {
        $siswa = CalonSiswa::first();
        if (!$siswa) {
            $siswa = CalonSiswa::create([
                'nama_lengkap'  => 'Test Siswa Nilai Seleksi',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir'  => 'Batam',
                'tanggal_lahir' => '2019-03-15',
                'status'        => 'diverifikasi',
            ]);
        }
        return $siswa;
    }

    public function test_admin_can_access_nilai_seleksi_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('nilai-seleksi.index'));
        $response->assertStatus(200);
        $response->assertSee('Penilaian Seleksi');
    }

    public function test_datatables_ajax_returns_nilai_seleksi_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('nilai-seleksi.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_can_access_edit_scoring_page(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = $this->getOrCreateCalonSiswa();

        $response = $this->actingAs($admin)->get(route('nilai-seleksi.edit', $siswa->id_calon_siswa));
        $response->assertStatus(200);
        $response->assertSee('Lembar Penilaian Komponen Seleksi');
        $response->assertSee($siswa->nama_lengkap);
    }

    public function test_can_save_scores_and_update_recommendation(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = $this->getOrCreateCalonSiswa();

        $komponen = KomponenSeleksi::first();
        if (!$komponen) {
            $komponen = KomponenSeleksi::create([
                'nama_komponen' => 'Tes Observasi dan Kemandirian',
                'bobot'         => 40.00,
                'keterangan'    => 'Observasi psikologis dan kemandirian dasar',
            ]);
        }

        $scores = [
            $komponen->id_komponen_seleksi => 85.50,
        ];
        $notes = [
            $komponen->id_komponen_seleksi => 'Sangat mandiri dan komunikatif',
        ];

        $response = $this->actingAs($admin)->put(route('nilai-seleksi.update', $siswa->id_calon_siswa), [
            'nilai'              => $scores,
            'catatan'            => $notes,
            'status_rekomendasi' => 'diterima',
        ]);

        $response->assertRedirect(route('nilai-seleksi.index'));

        $this->assertDatabaseHas('nilai_seleksi', [
            'id_calon_siswa'       => $siswa->id_calon_siswa,
            'id_komponen_seleksi'  => $komponen->id_komponen_seleksi,
            'nilai'                => 85.50,
        ]);

        $this->assertDatabaseHas('calon_siswa', [
            'id_calon_siswa' => $siswa->id_calon_siswa,
            'status'         => 'diterima',
        ]);
    }
}
