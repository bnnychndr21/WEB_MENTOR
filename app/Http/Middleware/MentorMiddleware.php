<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MentorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->role === 'mahasiswa') {
            return redirect()->intended(route('mahasiswa.dashboard', absolute: false));
        }

        if ($user->role !== 'mentor') {
            abort(403, 'Akses hanya untuk Mentor');
        }

        return $next($request);
    }
}
