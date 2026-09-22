<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKomponenSeleksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_komponen' => 'required|string|max:150',
            'kode'          => 'nullable|string|max:50',
            'nilai_minimal' => 'nullable|numeric|between:0,100',
            'bobot_persen'  => 'nullable|integer|between:0,100',
            'urutan'        => 'nullable|integer|min:1',
            'keterangan'    => 'nullable|string',
            'is_active'     => 'nullable|boolean',
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
            'nama_komponen.required' => 'Nama komponen seleksi wajib diisi.',
            'nilai_minimal.numeric'  => 'Nilai minimal harus berupa angka.',
            'bobot_persen.integer'   => 'Bobot persen harus berupa angka bulat.',
        ];
    }
}
