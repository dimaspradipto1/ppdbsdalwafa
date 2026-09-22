<?php

namespace Tests\Feature;

use App\Models\Gelombang;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GelombangTest extends TestCase
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

    public function test_super_admin_can_access_gelombang_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('gelombang.index'));
        $response->assertStatus(200);
        $response->assertSee('Master Gelombang Pendaftaran');
    }

    public function test_datatables_ajax_returns_gelombang_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('gelombang.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_unauthorized_role_cannot_access_gelombang(): void
    {
        $pendaftar = User::firstOrCreate(
            ['email' => 'pendaftar@gmail.com'],
            [
                'name'     => 'Pendaftar',
                'password' => Hash::make('password'),
                'role'     => 'pendaftar',
            ]
        );

        $response = $this->actingAs($pendaftar)->get(route('gelombang.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_create_gelombang(): void
    {
        $admin = $this->getSuperAdmin();
        $ta = TahunAjaran::first();

        Gelombang::where('nama_gelombang', 'Gelombang Uji Coba')->delete();

        $data = [
            'id_tahun_ajaran' => optional($ta)->id_tahun_ajaran,
            'nama_gelombang'  => 'Gelombang Uji Coba',
            'tanggal_mulai'   => '2027-01-01',
            'tanggal_selesai' => '2027-03-31',
            'kuota'           => 50,
            'is_active'       => 1,
            'keterangan'      => 'Keterangan gelombang uji coba',
        ];

        $response = $this->actingAs($admin)->post(route('gelombang.store'), $data);
        $response->assertRedirect(route('gelombang.index'));

        $this->assertDatabaseHas('gelombang', [
            'nama_gelombang' => 'Gelombang Uji Coba',
            'kuota'          => 50,
            'is_active'      => true,
        ]);
    }

    public function test_super_admin_can_update_gelombang(): void
    {
        $admin = $this->getSuperAdmin();
        $ta = TahunAjaran::first();

        $gelombang = Gelombang::create([
            'id_tahun_ajaran' => optional($ta)->id_tahun_ajaran,
            'nama_gelombang'  => 'Gelombang To Edit',
            'tanggal_mulai'   => '2027-04-01',
            'tanggal_selesai' => '2027-05-31',
            'kuota'           => 30,
            'is_active'       => false,
        ]);

        $updateData = [
            'id_tahun_ajaran' => optional($ta)->id_tahun_ajaran,
            'nama_gelombang'  => 'Gelombang To Edit Updated',
            'tanggal_mulai'   => '2027-04-01',
            'tanggal_selesai' => '2027-06-15',
            'kuota'           => 45,
            'is_active'       => 1,
        ];

        $response = $this->actingAs($admin)->put(route('gelombang.update', $gelombang->id_gelombang), $updateData);
        $response->assertRedirect(route('gelombang.index'));

        $gelombang->refresh();
        $this->assertEquals('Gelombang To Edit Updated', $gelombang->nama_gelombang);
        $this->assertEquals(45, $gelombang->kuota);
        $this->assertTrue($gelombang->is_active);
    }

    public function test_super_admin_can_delete_gelombang_via_ajax(): void
    {
        $admin = $this->getSuperAdmin();

        $gelombang = Gelombang::create([
            'nama_gelombang'  => 'Gelombang To Delete',
            'tanggal_mulai'   => '2027-07-01',
            'tanggal_selesai' => '2027-08-31',
            'is_active'       => false,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('gelombang.destroy', $gelombang->id_gelombang), [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('gelombang', ['id_gelombang' => $gelombang->id_gelombang]);
    }
}
