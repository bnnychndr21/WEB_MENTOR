<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MahasiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->role === 'mentor') {
            return redirect()->intended(route('mentor.dashboard', absolute: false));
        }

        if ($user->role !== 'mahasiswa') {
            abort(403, 'Akses hanya untuk Mahasiswa');
        }

        return $next($request);
    }
}
