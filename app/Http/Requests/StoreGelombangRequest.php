<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGelombangRequest extends FormRequest
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
            'id_tahun_ajaran' => 'nullable|exists:tahun_ajaran,id_tahun_ajaran',
            'nama_gelombang'  => 'required|string|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota'           => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
            'keterangan'      => 'nullable|string|max:255',
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
            'nama_gelombang.required'        => 'Nama gelombang pendaftaran wajib diisi (contoh: Gelombang 1).',
            'nama_gelombang.string'          => 'Nama gelombang harus berupa teks.',
            'nama_gelombang.max'             => 'Nama gelombang maksimal 100 karakter.',
            'id_tahun_ajaran.exists'         => 'Tahun ajaran yang dipilih tidak valid.',
            'tanggal_mulai.required'         => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date'             => 'Format tanggal mulai tidak valid.',
            'tanggal_selesai.required'       => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.date'           => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama dengan atau setelah tanggal mulai.',
            'kuota.integer'                  => 'Kuota harus berupa angka bulat.',
            'kuota.min'                      => 'Kuota tidak boleh bernilai negatif.',
            'keterangan.max'                 => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
