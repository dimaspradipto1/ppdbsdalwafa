<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePembayaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_calon_siswa'         => 'required|exists:calon_siswa,id_calon_siswa',
            'id_biaya'               => 'nullable|exists:biaya_ppdb,id_biaya',
            'nominal'                => 'required|numeric|min:1',
            'metode_pembayaran'      => 'required|string|max:50',
            'nama_bank_pengirim'     => 'nullable|string|max:100',
            'nomor_rekening_pengirim'=> 'nullable|string|max:50',
            'atas_nama_pengirim'     => 'nullable|string|max:150',
            'status_pembayaran'      => 'required|in:menunggu_konfirmasi,lunas,ditolak',
            'bukti_transfer'         => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:3072',
            'catatan'                => 'nullable|string|max:500',
            'tanggal_bayar'          => 'nullable|date',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('nominal')) {
            $this->merge([
                'nominal' => str_replace(['.', ','], ['', '.'], (string)$this->nominal),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'nominal.required'           => 'Nominal pembayaran wajib diisi.',
            'status_pembayaran.required' => 'Status pembayaran wajib dipilih.',
            'bukti_transfer.mimes'       => 'Bukti transfer harus berformat JPG, PNG, atau PDF.',
            'bukti_transfer.max'         => 'Ukuran bukti transfer maksimal 3 MB.',
        ];
    }
}
