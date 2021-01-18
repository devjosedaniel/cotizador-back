<?php

use Illuminate\Http\Response;

namespace App\Http\Controllers;

use App\Categoria;
use App\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    public function index()
    {
        $productos = Producto::whereEstado(true)->get();
        foreach ($productos as $p) {
            $p->categoria = $p->categoria;
        }
        return response()->json(['ok' => true, 'productos' => $productos], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'nombre' => 'required|unique:productos,nombre',
            'precio' => 'required|min:1|numeric',
            'categoria_id' => 'required'
        ]);
        $producto = new Producto();
        $producto->nombre = $data['nombre'];
        $producto->precio = $data['precio'];
        $producto->categoria_id = $data['categoria_id'];
        $producto->save();
        return response()->json(['ok' => true, 'mensaje' => 'Producto agregado', 'producto' => $producto], 200);
    }
    public function show($id)
    {
        $producto = Producto::find($id);
        return response()->json(['ok' => true, 'producto' => $producto], 200);
    }

    public function delete($id)
    {
        $producto = Producto::find($id);
        $producto->estado = false;
        $producto->save();
        return response()->json(['ok' => true, 'mensaje' => 'Producto eliminado', 'producto' => $producto], 200);
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->validate($request, [
            'nombre' => 'required|unique:productos,nombre,' . $id,
            'precio' => 'required|min:1|numeric',
            'categoria_id' => 'required'
        ]);
        $producto = Producto::find($id);
        $producto->nombre = $data['nombre'];
        $producto->precio = $data['precio'];
        $producto->categoria_id = $data['categoria_id'];
        $producto->save();
        return response()->json(['ok' => true, 'mensaje' => 'Producto actualizado', 'producto' => $producto], 200);
    }
    public function categoria()
    {
        $categorias = Categoria::whereEstado(true)->get();
        foreach ($categorias as $cat) {
            $cat->productos = $cat->productos;
        }
        return response()->json(['ok' => true, 'categorias' => $categorias]);
    }
}
