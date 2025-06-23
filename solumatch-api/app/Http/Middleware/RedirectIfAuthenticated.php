<?php

namespace App\Http\Middleware;

// A linha 'use App\Providers\RouteServiceProvider;' foi removida daqui.
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // MUDANÇA AQUI: Em vez de usar 'RouteServiceProvider::HOME',
                // nós definimos o caminho diretamente.
                return redirect('/home');
            }
        }

        return $next($request);
    }
}