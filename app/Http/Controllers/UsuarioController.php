<?php

use Illuminate\Http\Response;

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UsuarioController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'email' => 'required|unique:usuarios,email',
            'password'  => 'required',
            'nombre' => 'required',
        ]);
        $usuario = new User();
        $usuario->nombre = $data['nombre'];
        $usuario->email = $data['email'];
        $usuario->password = Crypt::encrypt($data['password']);;
        $usuario->save();
        return response()->json(['usuario' => $usuario, 'mensaje' => 'Usuario agregado', 'ok' => true], 200);
    }
    public function show($id)
    {
    }
    public function index()
    {
    }
    public function auth(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'usuario' => 'required',
            'password'  => 'required'
        ]);
        $usuario = User::whereEmail($data['usuario'])->first();
        if ($usuario) {
            try {
                $decrypted = Crypt::decrypt($usuario->password);
            } catch (DecryptException $e) {
            }
            if ($decrypted === $data['password']) {
                return response()->json(['usuario' => $usuario, 'ok' => true], 200);
            }
            return response()->json(['ok' => false, 'mensaje' => 'Usuario o contraseña no válido.'], 400);
        }
        return response()->json(['ok' => false, 'mensaje' => 'Usuario o contraseña no válido.'], 400);
    }
}
