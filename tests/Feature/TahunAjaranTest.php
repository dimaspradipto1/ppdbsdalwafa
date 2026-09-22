<?php

namespace Tests\Feature;

use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TahunAjaranTest extends TestCase
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

    public function test_super_admin_can_access_tahun_ajaran_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('tahun-ajaran.index'));
        $response->assertStatus(200);
        $response->assertSee('Master Data Tahun Ajaran');
    }

    public function test_datatables_ajax_returns_tahun_ajaran_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('tahun-ajaran.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data'
        ]);
    }

    public function test_unauthorized_role_cannot_access_tahun_ajaran(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('tahun-ajaran.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_create_tahun_ajaran(): void
    {
        $admin = $this->getSuperAdmin();

        TahunAjaran::where('tahun_ajaran', '2030/2031')->delete();

        $data = [
            'tahun_ajaran'      => '2030/2031',
            'nama_tahun_ajaran' => 'Tahun Ajaran 2030/2031',
            'tanggal_mulai'     => '2030-07-01',
            'tanggal_selesai'   => '2031-06-30',
            'is_active'         => 1,
            'keterangan'        => 'Tahun ajaran uji coba',
        ];

        $response = $this->actingAs($admin)->post(route('tahun-ajaran.store'), $data);
        $response->assertRedirect(route('tahun-ajaran.index'));

        $this->assertDatabaseHas('tahun_ajaran', [
            'tahun_ajaran' => '2030/2031',
            'is_active'    => true,
        ]);
    }

    public function test_super_admin_can_update_tahun_ajaran(): void
    {
        $admin = $this->getSuperAdmin();

        TahunAjaran::whereIn('tahun_ajaran', ['2032/2033', '2032/2033 Rev'])->delete();

        $tahunAjaran = TahunAjaran::create([
            'tahun_ajaran'      => '2032/2033',
            'nama_tahun_ajaran' => 'Tahun Ajaran 2032/2033 Awal',
            'is_active'         => false,
        ]);

        $updateData = [
            'tahun_ajaran'      => '2032/2033 Rev',
            'nama_tahun_ajaran' => 'Tahun Ajaran 2032/2033 Revisi',
            'is_active'         => 1,
        ];

        $response = $this->actingAs($admin)->put(route('tahun-ajaran.update', $tahunAjaran->id_tahun_ajaran), $updateData);
        $response->assertRedirect(route('tahun-ajaran.index'));

        $tahunAjaran->refresh();
        $this->assertEquals('2032/2033 Rev', $tahunAjaran->tahun_ajaran);
        $this->assertEquals('Tahun Ajaran 2032/2033 Revisi', $tahunAjaran->nama_tahun_ajaran);
        $this->assertTrue($tahunAjaran->is_active);
    }

    public function test_super_admin_can_delete_tahun_ajaran_via_ajax(): void
    {
        $admin = $this->getSuperAdmin();

        TahunAjaran::where('tahun_ajaran', '2034/2035')->delete();

        $tahunAjaran = TahunAjaran::create([
            'tahun_ajaran'      => '2034/2035',
            'nama_tahun_ajaran' => 'Akan Dihapus',
            'is_active'         => false,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('tahun-ajaran.destroy', $tahunAjaran->id_tahun_ajaran), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('tahun_ajaran', ['id_tahun_ajaran' => $tahunAjaran->id_tahun_ajaran]);
    }
}
