<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Crypt;

class JwtAuth
{
    protected $key = 'sup3r/cl@v3-d3-gener@c!on-tok3n-jd2021';
    public function signup($email, $password, $getToken = false)
    {
        $usuario = User::where(['email' => $email])->first();

        if ($usuario) {
            if (Crypt::decrypt($usuario->password) != $password) {
                return response()->json(['ok' => false, 'mensaje' => 'Usuario o contraseña incorrectos'], 400);
            }
            $token = array(
                'sub' => $usuario->id,
                'email' => $usuario->email,
                'nombre' => $usuario->nombre,
                'iat' => time(),
                'exp' => time() + (60 * 60 * 5)
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            if ($getToken) {
                $decoded = JWT::decode($jwt, $this->key, ['HS256']);
                return response()->json($decoded);
            } else {
                return  response()->json($jwt, 200);
            }
        }
        return response()->json(['ok' => false, 'mensaje' => 'Usuario o contraseña incorrectos'], 400);
    }

    public function checkToken($jwt, $getIdentity = false)
    {
        $auth = false;
        try {
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $ex) {
            $auth = false;
        } catch (\DomainException $ex) {
            $auth = false;
        }
        if (!empty($decoded) && is_object($decoded)) {
            $auth = true;
        } else {
            $auth = false;
        }
        if ($getIdentity) {
            return $decoded;
        }
        return $auth;
    }
}
