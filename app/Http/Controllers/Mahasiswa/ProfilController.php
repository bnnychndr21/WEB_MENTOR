<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\MahasiswaProfilRequest;
use App\Models\MahasiswaProfil;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function show(): View
    {
        $profil = auth()->user()->mahasiswaProfil;

        return view('mahasiswa.profil', compact('profil'));
    }

    public function edit(): View
    {
        $profil = auth()->user()->mahasiswaProfil;

        return view('mahasiswa.profil-edit', compact('profil'));
    }

    public function update(MahasiswaProfilRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($user->mahasiswaProfil?->foto) {
                Storage::disk('public')->delete($user->mahasiswaProfil->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto-mahasiswa', 'public');
        }

        MahasiswaProfil::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('mahasiswa.profil')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
