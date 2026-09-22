<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBiayaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_tahun_ajaran' => 'nullable|exists:tahun_ajaran,id_tahun_ajaran',
            'id_gelombang'    => 'nullable|exists:gelombang,id_gelombang',
            'id_jalur'        => 'nullable|exists:jalur,id_jalur',
            'nama_biaya'      => 'required|string|max:150',
            'jenis_biaya'     => 'required|string|max:50',
            'nominal'         => 'required|numeric|min:0',
            'tipe_pembayaran' => 'required|string|max:50',
            'is_wajib'        => 'nullable|boolean',
            'is_active'       => 'nullable|boolean',
            'keterangan'      => 'nullable|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nominal'   => str_replace(['.', ','], ['', '.'], (string)$this->nominal),
            'is_wajib'  => $this->boolean('is_wajib'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'nama_biaya.required'  => 'Nama biaya / tarif wajib diisi.',
            'nominal.required'     => 'Nominal tarif wajib diisi.',
            'nominal.numeric'      => 'Nominal tarif harus berupa angka.',
            'nominal.min'          => 'Nominal tarif tidak boleh bernilai negatif.',
            'jenis_biaya.required' => 'Jenis / kategori biaya wajib dipilih.',
        ];
    }
}
