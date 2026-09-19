<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSekolahRequest extends FormRequest
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
        $sekolahId = $this->route('sekolah') instanceof \App\Models\Sekolah 
            ? $this->route('sekolah')->id_sekolah 
            : $this->route('sekolah');

        return [
            'npsn'           => ['nullable', 'string', 'max:20', Rule::unique('sekolah', 'npsn')->ignore($sekolahId, 'id_sekolah')],
            'nama_sekolah'   => 'required|string|max:255',
            'jenjang'        => 'required|string|max:50',
            'status_sekolah' => 'required|string|max:50',
            'nama_yayasan'   => 'nullable|string|max:255',
            'alamat'         => 'nullable|string',
            'desa_kelurahan' => 'nullable|string|max:100',
            'kecamatan'      => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'provinsi'       => 'nullable|string|max:100',
            'kode_pos'       => 'nullable|string|max:10',
            'telepon'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:255',
            'website'        => 'nullable|string|max:255',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'nama_sekolah.required'   => 'Nama sekolah wajib diisi.',
            'npsn.unique'             => 'NPSN tersebut sudah terdaftar pada sekolah lain.',
            'jenjang.required'        => 'Jenjang pendidikan wajib dipilih.',
            'status_sekolah.required' => 'Status sekolah wajib dipilih.',
            'email.email'             => 'Format alamat email tidak valid.',
            'logo.image'              => 'File logo harus berupa gambar.',
            'logo.mimes'              => 'Format logo yang diperbolehkan: JPG, JPEG, PNG, WEBP.',
            'logo.max'                => 'Ukuran file logo maksimal 2MB.',
            'latitude.numeric'        => 'Nilai latitude harus berupa angka.',
            'longitude.numeric'       => 'Nilai longitude harus berupa angka.',
        ];
    }
}
