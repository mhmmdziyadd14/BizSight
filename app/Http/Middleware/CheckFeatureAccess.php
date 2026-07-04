<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFeatureAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $featureCode): Response
    {
        $user = auth()->user();

        // Admin bypasses all checks
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // Check if user has access to the feature
        $hasAccess = $user && $user->hasAccessTo($featureCode);

        if (!$hasAccess) {
            return redirect()->route('welcome')->with('error', "Akses Ditolak: Anda belum membeli fitur ini atau masa trial Anda telah habis.");
        }

        return $next($request);
    }
}
