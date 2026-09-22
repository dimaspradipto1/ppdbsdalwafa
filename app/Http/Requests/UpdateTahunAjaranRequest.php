<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTahunAjaranRequest extends FormRequest
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
        $tahunAjaran = $this->route('tahunAjaran') ?? $this->route('tahun_ajaran');
        $idTahunAjaran = is_object($tahunAjaran) ? $tahunAjaran->id_tahun_ajaran : $tahunAjaran;

        return [
            'tahun_ajaran' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tahun_ajaran', 'tahun_ajaran')->ignore($idTahunAjaran, 'id_tahun_ajaran'),
            ],
            'nama_tahun_ajaran' => 'nullable|string|max:100',
            'tanggal_mulai'     => 'nullable|date',
            'tanggal_selesai'   => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active'         => 'nullable|boolean',
            'keterangan'        => 'nullable|string|max:255',
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
            'tahun_ajaran.required'            => 'Tahun ajaran wajib diisi (contoh: 2025/2026).',
            'tahun_ajaran.string'              => 'Tahun ajaran harus berupa teks.',
            'tahun_ajaran.max'                 => 'Tahun ajaran maksimal 20 karakter.',
            'tahun_ajaran.unique'              => 'Tahun ajaran ini sudah terdaftar.',
            'nama_tahun_ajaran.max'            => 'Nama tahun ajaran maksimal 100 karakter.',
            'tanggal_mulai.date'               => 'Format tanggal mulai tidak valid.',
            'tanggal_selesai.date'             => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal'   => 'Tanggal selesai harus sama dengan atau setelah tanggal mulai.',
            'keterangan.max'                   => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
