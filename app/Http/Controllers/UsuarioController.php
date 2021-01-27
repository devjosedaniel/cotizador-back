<?php

use Illuminate\Http\Response;

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'auth'
        ]]);
    }
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
        $jwtAuth = new JwtAuth();
        return $jwtAuth->signup($data['usuario'], $data['password']);
    }
}
