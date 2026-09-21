<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePendidikanRequest extends FormRequest
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
        $pendidikan = $this->route('pendidikan');
        $idPendidikan = is_object($pendidikan) ? $pendidikan->id_pendidikan : $pendidikan;

        return [
            'nama_pendidikan' => [
                'required',
                'string',
                'max:50',
                Rule::unique('pendidikan', 'nama_pendidikan')->ignore($idPendidikan, 'id_pendidikan'),
            ],
            'keterangan'      => 'nullable|string|max:255',
            'is_active'       => 'nullable|boolean',
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
            'nama_pendidikan.required' => 'Nama jenjang pendidikan wajib diisi.',
            'nama_pendidikan.string'   => 'Nama jenjang pendidikan harus berupa teks.',
            'nama_pendidikan.max'      => 'Nama jenjang pendidikan tidak boleh lebih dari 50 karakter.',
            'nama_pendidikan.unique'   => 'Nama jenjang pendidikan tersebut sudah terdaftar.',
            'keterangan.max'           => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
