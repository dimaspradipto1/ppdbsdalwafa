<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDokumenSiswaRequest extends FormRequest
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
            'id_calon_siswa'     => 'required|exists:calon_siswa,id_calon_siswa',
            'id_jenis_dokumen'   => 'required|exists:ref_jenis_dokumen,id_jenis_dokumen',
            'berkas'             => 'required|file|mimes:pdf,jpg,jpeg,png|max:3072', // Maksimal 3MB
            'status_verifikasi'  => 'nullable|in:menunggu,valid,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:255',
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'id_calon_siswa.required'   => 'Calon siswa wajib dipilih.',
            'id_calon_siswa.exists'     => 'Calon siswa yang dipilih tidak valid.',
            'id_jenis_dokumen.required' => 'Jenis dokumen persyaratan wajib dipilih.',
            'id_jenis_dokumen.exists'   => 'Jenis dokumen yang dipilih tidak valid.',
            'berkas.required'           => 'File berkas dokumen wajib diunggah.',
            'berkas.file'               => 'Berkas harus berupa file yang valid.',
            'berkas.mimes'              => 'Format berkas harus berupa PDF, JPG, JPEG, atau PNG.',
            'berkas.max'                => 'Ukuran berkas tidak boleh lebih dari 3MB (3072 KB).',
        ];
    }
}
