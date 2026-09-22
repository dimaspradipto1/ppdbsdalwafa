<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJalurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jalur = $this->route('jalur');
        $idJalur = is_object($jalur) ? $jalur->id_jalur : $jalur;

        return [
            'id_tahun_ajaran'    => 'nullable|exists:tahun_ajaran,id_tahun_ajaran',
            'nama_jalur'         => 'required|string|max:100',
            'kode_jalur'         => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('jalur', 'kode_jalur')->ignore($idJalur, 'id_jalur'),
            ],
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
