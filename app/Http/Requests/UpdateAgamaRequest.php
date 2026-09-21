<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAgamaRequest extends FormRequest
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
        $agama = $this->route('agama');
        $idAgama = is_object($agama) ? $agama->id_agama : $agama;

        return [
            'nama_agama' => [
                'required',
                'string',
                'max:50',
                Rule::unique('agama', 'nama_agama')->ignore($idAgama, 'id_agama'),
            ],
            'keterangan' => 'nullable|string|max:255',
            'is_active'  => 'nullable|boolean',
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
            'nama_agama.required' => 'Nama agama wajib diisi.',
            'nama_agama.string'   => 'Nama agama harus berupa teks.',
            'nama_agama.max'      => 'Nama agama tidak boleh lebih dari 50 karakter.',
            'nama_agama.unique'   => 'Nama agama tersebut sudah terdaftar.',
            'keterangan.max'      => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
