<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePenghasilanRequest extends FormRequest
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
        $penghasilan = $this->route('penghasilan');
        $idPenghasilan = is_object($penghasilan) ? $penghasilan->id_penghasilan : $penghasilan;

        return [
            'label' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ref_penghasilan', 'label')->ignore($idPenghasilan, 'id_penghasilan'),
            ],
            'batas_bawah' => 'nullable|numeric|min:0',
            'batas_atas'  => 'nullable|numeric|min:0',
            'urutan'      => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ];
    }

    /**
     * Prepare data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'   => $this->boolean('is_active'),
            'urutan'      => $this->filled('urutan') ? (int) $this->urutan : 0,
            'batas_bawah' => $this->filled('batas_bawah') ? $this->batas_bawah : null,
            'batas_atas'  => $this->filled('batas_atas') ? $this->batas_atas : null,
        ]);
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'label.required'      => 'Label rentang penghasilan wajib diisi.',
            'label.string'        => 'Label rentang penghasilan harus berupa teks.',
            'label.max'           => 'Label rentang penghasilan tidak boleh lebih dari 100 karakter.',
            'label.unique'        => 'Label rentang penghasilan tersebut sudah terdaftar.',
            'batas_bawah.numeric' => 'Batas bawah harus berupa angka nominal.',
            'batas_bawah.min'     => 'Batas bawah tidak boleh bernilai negatif.',
            'batas_atas.numeric'  => 'Batas atas harus berupa angka nominal.',
            'batas_atas.min'      => 'Batas atas tidak boleh bernilai negatif.',
            'urutan.integer'      => 'Urutan harus berupa angka bulat positif.',
            'urutan.min'          => 'Urutan minimal bernilai 0.',
        ];
    }
}
