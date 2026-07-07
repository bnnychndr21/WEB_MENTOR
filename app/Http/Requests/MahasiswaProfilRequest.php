<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'universitas' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'semester' => 'required|integer|min:1|max:14',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'biodata' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'universitas.required' => 'Universitas wajib diisi',
            'universitas.max' => 'Universitas maksimal 100 karakter',
            'jurusan.required' => 'Jurusan wajib diisi',
            'jurusan.max' => 'Jurusan maksimal 100 karakter',
            'semester.required' => 'Semester wajib diisi',
            'semester.integer' => 'Semester harus berupa angka',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 14',
            'no_hp.max' => 'No HP maksimal 15 karakter',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran foto maksimal 2MB',
            'biodata.max' => 'Biodata maksimal 500 karakter',
        ];
    }
}
