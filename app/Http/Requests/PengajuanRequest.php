<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mentor_id' => 'required|exists:mentor_profils,id',
            'jadwal_id' => [
                'required',
                'exists:jadwals,id,tersedia,1',
                function ($attribute, $value, $fail) {
                    $jadwal = \App\Models\Jadwal::find($value);
                    if ($jadwal && $jadwal->mentor_id != request('mentor_id')) {
                        $fail('Jadwal tidak sesuai dengan mentor yang dipilih.');
                    }
                },
            ],
            'jam' => 'required|date_format:H:i',
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'required|string|min:10|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'mentor_id.required' => 'Mentor harus dipilih.',
            'mentor_id.exists' => 'Mentor tidak valid.',
            'jadwal_id.required' => 'Jadwal konsultasi harus dipilih.',
            'jadwal_id.exists' => 'Jadwal tidak valid atau sudah dipesan.',
            'jam.required' => 'Jam konsultasi harus dipilih.',
            'jam.date_format' => 'Format jam tidak valid.',
            'tanggal.required' => 'Tanggal konsultasi harus dipilih.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'judul.required' => 'Topik harus diisi.',
            'judul.max' => 'Topik maksimal 200 karakter.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 2000 karakter.',
        ];
    }
}
