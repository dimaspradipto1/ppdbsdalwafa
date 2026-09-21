<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePekerjaanRequest extends FormRequest
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
        $pekerjaan = $this->route('pekerjaan');
        $idPekerjaan = is_object($pekerjaan) ? $pekerjaan->id_pekerjaan : $pekerjaan;

        return [
            'nama_pekerjaan' => [
                'required',
                'string',
                'max:50',
                Rule::unique('pekerjaan', 'nama_pekerjaan')->ignore($idPekerjaan, 'id_pekerjaan'),
            ],
            'keterangan'     => 'nullable|string|max:255',
            'is_active'      => 'nullable|boolean',
        ];
    }

    /**
     * Prepare data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'nama_pekerjaan.required' => 'Nama pekerjaan/profesi wajib diisi.',
            'nama_pekerjaan.string'   => 'Nama pekerjaan/profesi harus berupa teks.',
            'nama_pekerjaan.max'      => 'Nama pekerjaan/profesi tidak boleh lebih dari 50 karakter.',
            'nama_pekerjaan.unique'   => 'Nama pekerjaan/profesi tersebut sudah terdaftar.',
            'keterangan.max'          => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
