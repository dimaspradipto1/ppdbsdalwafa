<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJalurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_tahun_ajaran'    => 'nullable|exists:tahun_ajaran,id_tahun_ajaran',
            'nama_jalur'         => 'required|string|max:100',
            'kode_jalur'         => 'nullable|string|max:50|unique:jalur,kode_jalur',
            'kuota'              => 'nullable|integer|min:0',
            'deskripsi'          => 'nullable|string',
            'persyaratan_khusus' => 'nullable|string',
            'is_active'          => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'nama_jalur.required' => 'Nama jalur pendaftaran wajib diisi (contoh: Jalur Reguler).',
            'kode_jalur.unique'   => 'Kode jalur sudah terdaftar.',
            'kuota.integer'       => 'Kuota harus berupa angka bulat.',
            'kuota.min'           => 'Kuota tidak boleh bernilai negatif.',
        ];
    }
}
