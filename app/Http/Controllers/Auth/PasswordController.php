<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'kata_sandi_saat_ini' => ['required', 'current_password'],
            'kata_sandi' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'kata_sandi' => Hash::make($validated['kata_sandi']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
