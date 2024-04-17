<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckFacultyId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       if ($request->is('logout') || $request->routeIs('logout')) {
            return $next($request);
        }
        $user = Auth::user();

        // Verificar si faculty_id es null
        if ($user->faculty_id === null) {
            // Redirigir al perfil para completar la información
            return redirect()->route('profile.show');
        }
        return $next($request);
    }
}
