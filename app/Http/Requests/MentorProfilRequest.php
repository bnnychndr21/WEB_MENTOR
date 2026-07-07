<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MentorProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gelar' => 'nullable|string|max:100',
            'universitas' => 'required|string|max:100',
            'tahun_lulus' => 'nullable|integer|min:1980|max:' . date('Y'),
            'pekerjaan' => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'pengalaman' => 'nullable|string|max:2000',
            'bio' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'gelar.max' => 'Gelar maksimal 100 karakter',
            'universitas.required' => 'Universitas wajib diisi',
            'universitas.max' => 'Universitas maksimal 100 karakter',
            'tahun_lulus.integer' => 'Tahun lulus harus berupa angka',
            'tahun_lulus.min' => 'Tahun lulus minimal 1980',
            'tahun_lulus.max' => 'Tahun lulus tidak valid',
            'pekerjaan.max' => 'Pekerjaan maksimal 100 karakter',
            'perusahaan.max' => 'Perusahaan maksimal 100 karakter',
            'pengalaman.max' => 'Pengalaman maksimal 2000 karakter',
            'bio.max' => 'Bio maksimal 500 karakter',
            'no_hp.max' => 'No HP maksimal 15 karakter',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ];
    }
}
