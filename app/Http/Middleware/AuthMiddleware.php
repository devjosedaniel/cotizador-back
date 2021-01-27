<?php

namespace App\Http\Middleware;

use App\Helpers\JwtAuth;
use Closure;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['ok' => false, 'mensaje' => 'Autorización necesaria'], 401);
        }
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if ($checkToken) {
            return $next($request);
        } else {
            return response()->json(['ok' => false, 'mensaje' => 'Usuario no autenticado, inicie sesión. '], 401);
        }
    }
}
