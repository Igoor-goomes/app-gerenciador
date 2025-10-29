<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRecentToken
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $token = $user?->currentAccessToken();

        if (!$token) {
            return response()->json([
                'data' => null,
                'message' => 'Token não fornecido.',
                'errors' => ['token' => ['Token ausente']],
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Janela em minutos (default 10)
        $ttl = (int) (env('SANCTUM_TOKEN_TTL', 10));
        $created = $token->created_at;
        if ($created && now()->diffInMinutes($created) > $ttl) {
            return response()->json([
                'data' => null,
                'message' => 'Token expirado.',
                'errors' => ['token' => ['Expirado']],
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}

