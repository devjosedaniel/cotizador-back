<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    public function index()
    {
        $categorias = Categoria::whereEstado(true)->get();
        return response()->json(['ok' => true, 'categorias' => $categorias], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'nombre' => 'required|unique:categorias,nombre',
        ]);
        $categoria = new Categoria();
        $categoria->nombre = $data['nombre'];
        $categoria->save();
        return response()->json(['ok' => true, 'mensaje' => 'Categoria agregada', 'categoria' => $categoria], 200);
    }
    public function show($id)
    {
        $categoria = Categoria::find($id);
        return response()->json(['ok' => true, 'categoria' => $categoria], 200);
    }

    public function delete($id)
    {
        $categoria = Categoria::find($id);
        $categoria->estado = false;
        $categoria->save();
        return response()->json(['ok' => true, 'mensaje' => 'Categoria eliminada', 'categoria' => $categoria], 200);
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->validate($request, [
            'nombre' => 'required|unique:categorias,nombre,' . $id,
        ]);
        $categoria = Categoria::find($id);
        $categoria->nombre = $data['nombre'];
        $categoria->save();
        return response()->json(['ok' => true, 'mensaje' => 'Categoria actualizada', 'categoria' => $categoria], 200);
    }
}
