<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalonSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 1. Identitas Peserta Didik
            'nama_lengkap'           => 'required|string|max:150',
            'jenis_kelamin'          => 'required|in:Laki-laki,Perempuan',
            'nik'                    => 'nullable|string|size:16',
            'nisn'                   => 'nullable|string|max:10',
            'tempat_lahir'           => 'required|string|max:100',
            'tanggal_lahir'          => 'required|date',
            'id_agama'               => 'nullable|exists:agama,id_agama',
            'jumlah_saudara_kandung' => 'nullable|integer|min:0',
            'anak_ke'                => 'nullable|integer|min:1',
            'id_kebutuhan_khusus'    => 'nullable|exists:ref_kebutuhan_khusus,id_kebutuhan',

            // Alamat Tempat Tinggal
            'alamat_jalan'           => 'nullable|string|max:255',
            'rt'                     => 'nullable|string|max:5',
            'rw'                     => 'nullable|string|max:5',
            'kelurahan'              => 'nullable|string|max:100',
            'kode_pos'               => 'nullable|string|max:10',
            'kecamatan'              => 'nullable|string|max:100',
            'kabupaten_kota'         => 'nullable|string|max:100',
            'provinsi'               => 'nullable|string|max:100',
            'alat_transportasi'      => 'nullable|string|max:100',
            'jenis_tinggal'          => 'nullable|string|max:100',
            'telepon_rumah'          => 'nullable|string|max:20',
            'no_hp'                  => 'nullable|string|max:20',
            'jarak_ke_sekolah'       => 'nullable|string|max:50',
            'jarak_ke_sekolah_detail'=> 'nullable|string|max:50',
            'waktu_tempuh'           => 'nullable|string|max:50',
            'email'                  => 'nullable|email|max:100',
            'asal_sekolah'           => 'nullable|string|max:150',

            // 2. Data Ayah Kandung
            'nama_ayah'              => 'nullable|string|max:150',
            'tempat_lahir_ayah'      => 'nullable|string|max:100',
            'tanggal_lahir_ayah'     => 'nullable|date',
            'pekerjaan_ayah_id'      => 'nullable|exists:pekerjaan,id_pekerjaan',
            'pendidikan_ayah_id'     => 'nullable|exists:pendidikan,id_pendidikan',
            'agama_ayah_id'          => 'nullable|exists:agama,id_agama',
            'penghasilan_ayah_id'    => 'nullable|exists:ref_penghasilan,id_penghasilan',

            // 3. Data Ibu Kandung
            'nama_ibu'               => 'nullable|string|max:150',
            'tempat_lahir_ibu'       => 'nullable|string|max:100',
            'tanggal_lahir_ibu'      => 'nullable|date',
            'pekerjaan_ibu_id'       => 'nullable|exists:pekerjaan,id_pekerjaan',
            'pendidikan_ibu_id'      => 'nullable|exists:pendidikan,id_pendidikan',
            'agama_ibu_id'           => 'nullable|exists:agama,id_agama',
            'penghasilan_ibu_id'     => 'nullable|exists:ref_penghasilan,id_penghasilan',

            // 4. Data Wali
            'nama_wali'              => 'nullable|string|max:150',
            'tempat_lahir_wali'      => 'nullable|string|max:100',
            'tanggal_lahir_wali'     => 'nullable|date',
            'pekerjaan_wali_id'      => 'nullable|exists:pekerjaan,id_pekerjaan',
            'pendidikan_wali_id'     => 'nullable|exists:pendidikan,id_pendidikan',
            'agama_wali_id'          => 'nullable|exists:agama,id_agama',
            'penghasilan_wali_id'    => 'nullable|exists:ref_penghasilan,id_penghasilan',

            // Status
            'status'                 => 'nullable|in:draft,menunggu_verifikasi,diverifikasi,diterima,ditolak',

            // 5. Catatan Prestasi (Dynamic Array)
            'prestasi'                       => 'nullable|array',
            'prestasi.*.jenis_prestasi'      => 'nullable|string|max:50',
            'prestasi.*.tingkat'             => 'nullable|string|max:50',
            'prestasi.*.nama_prestasi'       => 'nullable|string|max:150',
            'prestasi.*.tahun'               => 'nullable|string|max:4',
            'prestasi.*.penyelenggara'       => 'nullable|string|max:150',

            // 6. Beasiswa (Dynamic Array)
            'beasiswa'                       => 'nullable|array',
            'beasiswa.*.jenis_beasiswa'      => 'nullable|string|max:100',
            'beasiswa.*.penyelenggara'       => 'nullable|string|max:150',
            'beasiswa.*.tahun_mulai'         => 'nullable|string|max:4',
            'beasiswa.*.tahun_selesai'       => 'nullable|string|max:4',
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'nama_lengkap.required'   => 'Nama lengkap calon siswa wajib diisi.',
            'jenis_kelamin.required'  => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'        => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'tempat_lahir.required'   => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'      => 'Format tanggal lahir tidak valid.',
            'nik.size'                => 'NIK harus terdiri dari 16 digit.',
            'email.email'             => 'Format alamat email tidak valid.',
        ];
    }
}
