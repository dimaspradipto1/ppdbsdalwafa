<?php

namespace Tests\Feature;

use App\Models\Biaya;
use App\Models\CalonSiswa;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PembayaranTest extends TestCase
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
                'nama_lengkap'  => 'Test Siswa Pembayaran',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir'  => 'Batam',
                'tanggal_lahir' => '2019-01-01',
                'status'        => 'menunggu_verifikasi',
            ]);
        }
        return $siswa;
    }

    public function test_admin_can_access_pembayaran_index(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)->get(route('pembayaran.index'));
        $response->assertStatus(200);
        $response->assertSee('Pembayaran PPDB');
    }

    public function test_datatables_ajax_returns_pembayaran_json(): void
    {
        $admin = $this->getSuperAdmin();

        $response = $this->actingAs($admin)
            ->get(route('pembayaran.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
    }

    public function test_store_pembayaran_auto_generates_kode_transaksi(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = $this->getOrCreateCalonSiswa();
        $biaya = Biaya::first();

        $response = $this->actingAs($admin)->post(route('pembayaran.store'), [
            'id_calon_siswa'    => $siswa->id_calon_siswa,
            'id_biaya'          => $biaya?->id_biaya,
            'nominal'           => 350000,
            'metode_pembayaran' => 'transfer',
            'nama_bank'         => 'BSI (Bank Syariah Indonesia)',
            'nomor_rekening'    => '7123456789',
            'atas_nama'         => 'Fulan bin Fulan',
            'status_pembayaran' => 'menunggu_konfirmasi',
            'tanggal_bayar'     => now()->toDateString(),
            'catatan'           => 'Pembayaran formulir PPDB gelombang 1',
        ]);

        $response->assertRedirect(route('pembayaran.index'));
        $this->assertDatabaseHas('pembayaran_ppdb', [
            'id_calon_siswa' => $siswa->id_calon_siswa,
            'nominal'        => 350000,
        ]);

        $pembayaran = Pembayaran::where('id_calon_siswa', $siswa->id_calon_siswa)->latest()->first();
        $this->assertNotNull($pembayaran->kode_transaksi);
        $this->assertStringStartsWith('INV-', $pembayaran->kode_transaksi);
    }

    public function test_can_update_status_pembayaran(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = $this->getOrCreateCalonSiswa();
        $pembayaran = Pembayaran::where('id_calon_siswa', $siswa->id_calon_siswa)->latest()->first();

        if (!$pembayaran) {
            $pembayaran = Pembayaran::create([
                'id_calon_siswa'    => $siswa->id_calon_siswa,
                'nominal'           => 350000,
                'metode_pembayaran' => 'transfer',
                'status_pembayaran' => 'menunggu_konfirmasi',
                'tanggal_bayar'     => now()->toDateString(),
            ]);
        }

        $response = $this->actingAs($admin)
            ->patchJson(route('pembayaran.update-status', $pembayaran->id_pembayaran), [
                'status_pembayaran' => 'lunas',
                'catatan'           => 'Bukti transfer valid dan dana telah masuk.',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('pembayaran_ppdb', [
            'id_pembayaran'     => $pembayaran->id_pembayaran,
            'status_pembayaran' => 'lunas',
        ]);
    }

    public function test_can_print_kwitansi_pembayaran(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = $this->getOrCreateCalonSiswa();
        $pembayaran = Pembayaran::where('id_calon_siswa', $siswa->id_calon_siswa)->latest()->first();

        $response = $this->actingAs($admin)->get(route('pembayaran.kwitansi', $pembayaran->id_pembayaran));
        $response->assertStatus(200);
        $response->assertSee('KWITANSI RESMI');
        $response->assertSee($pembayaran->kode_transaksi);
    }

    public function test_can_delete_pembayaran(): void
    {
        $admin = $this->getSuperAdmin();
        $siswa = $this->getOrCreateCalonSiswa();
        $pembayaran = Pembayaran::where('id_calon_siswa', $siswa->id_calon_siswa)->latest()->first();

        $response = $this->actingAs($admin)->delete(route('pembayaran.destroy', $pembayaran->id_pembayaran));
        $response->assertRedirect(route('pembayaran.index'));

        $this->assertDatabaseMissing('pembayaran_ppdb', [
            'id_pembayaran' => $pembayaran->id_pembayaran,
        ]);
    }
}
