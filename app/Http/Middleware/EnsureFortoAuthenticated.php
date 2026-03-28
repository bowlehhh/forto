<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFortoAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('forto_admin.authenticated')) {
            return redirect()
                ->route('login')
                ->with('status_title', 'Akses dibatasi')
                ->with('status_type', 'info')
                ->with('status', 'Silakan login dulu untuk membuka dashboard.');
        }

        return $next($request);
    }
}
