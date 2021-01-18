<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'identificador' => 'required|unique:clientes,identificador|min:10|max:13',
            'email' => 'required',
        ]);
        $cliente = new Cliente();
        $cliente->nombre = $data['nombre'];
        $cliente->direccion = $data['direccion'];
        $cliente->telefono = $data['telefono'];
        $cliente->identificador = $data['identificador'];
        $cliente->email = $data['email'];
        $cliente->save();
        return response()->json(['ok' => true, 'cliente' => $cliente, 'mensaje' => 'Cliente agregado'], 200);
    }
    public function index()
    {
        $clientes = Cliente::whereEstado(true)->get();
        return response()->json(['ok' => true, 'clientes' => $clientes], 200);
    }
    public function show($id)
    {
        $cliente = Cliente::find($id);
        return response()->json(['ok' => true, 'cliente' => $cliente], 200);
    }
    public function delete($id)
    {
        $cliente = Cliente::find($id);
        $cliente->estado = false;
        $cliente->save();
        return response()->json(['ok' => true, 'mensaje' => 'Cliente eliminado', 'cliente' => $cliente], 200);
    }
    public function update($id, Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'identificador' => 'required|unique:clientes,identificador,' . $id,
            'email' => 'required',
        ]);
        $cliente = Cliente::find($id);
        $cliente->nombre = $data['nombre'];
        $cliente->direccion = $data['direccion'];
        $cliente->telefono = $data['telefono'];
        $cliente->identificador = $data['identificador'];
        $cliente->email = $data['email'];
        $cliente->save();
        return response()->json(['ok' => true, 'cliente' => $cliente, 'mensaje' => 'Cliente actualizado.'], 200);
    }
}
