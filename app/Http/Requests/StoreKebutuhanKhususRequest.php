<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKebutuhanKhususRequest extends FormRequest
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
            'kode'       => 'required|string|max:50|unique:ref_kebutuhan_khusus,kode',
            'nama'       => 'required|string|max:150',
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
            'kode.required'       => 'Kode kebutuhan khusus wajib diisi.',
            'kode.string'         => 'Kode kebutuhan khusus harus berupa teks.',
            'kode.max'            => 'Kode kebutuhan khusus tidak boleh lebih dari 50 karakter.',
            'kode.unique'         => 'Kode kebutuhan khusus tersebut sudah terdaftar.',
            'nama.required'       => 'Nama kebutuhan khusus wajib diisi.',
            'nama.string'         => 'Nama kebutuhan khusus harus berupa teks.',
            'nama.max'            => 'Nama kebutuhan khusus tidak boleh lebih dari 150 karakter.',
            'keterangan.max'      => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
