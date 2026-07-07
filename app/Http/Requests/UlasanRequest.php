<?php

namespace App\Http\Requests;

use App\Models\PengajuanMentoring;
use Illuminate\Foundation\Http\FormRequest;

class UlasanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pengajuan = $this->route('pengajuan');
        if (!$pengajuan instanceof PengajuanMentoring) {
            $pengajuan = PengajuanMentoring::findOrFail($pengajuan);
        }

        return $pengajuan->mahasiswa_id === auth()->id()
            && $pengajuan->status === 'selesai'
            && !$pengajuan->ulasans()->where('mahasiswa_id', auth()->id())->exists();
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Rating harus diisi.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
            'komentar.max' => 'Komentar maksimal 1000 karakter.',
        ];
    }
}
