<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\MentorProfilRequest;
use App\Models\MentorProfil;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        $profil = $user->mentorProfil;

        return view('mentor.profil', compact('profil', 'user'));
    }

    public function edit(): View
    {
        $user = auth()->user();
        $profil = $user->mentorProfil;

        return view('mentor.profil-edit', compact('profil', 'user'));
    }

    public function update(MentorProfilRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($user->mentorProfil?->foto) {
                Storage::disk('public')->delete($user->mentorProfil->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto-mentor', 'public');
        }

        MentorProfil::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('mentor.profil')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
