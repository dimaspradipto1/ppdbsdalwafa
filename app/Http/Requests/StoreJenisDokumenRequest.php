<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisDokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode'          => 'required|string|max:50|unique:ref_jenis_dokumen,kode',
            'nama_dokumen'  => 'required|string|max:150',
            'kategori'      => 'required|in:semua,siswa_baru,siswa_pindahan',
            'jumlah_lembar' => 'nullable|string|max:100',
            'keterangan'    => 'nullable|string|max:255',
            'is_wajib'      => 'nullable|boolean',
            'is_active'     => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_wajib'  => $this->boolean('is_wajib'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'kode.required'         => 'Kode dokumen wajib diisi (contoh: AKTA_KK).',
            'kode.unique'           => 'Kode dokumen sudah terdaftar.',
            'nama_dokumen.required' => 'Nama dokumen / persyaratan wajib diisi.',
            'kategori.required'     => 'Kategori persyaratan wajib dipilih.',
            'kategori.in'           => 'Kategori tidak valid.',
        ];
    }
}
