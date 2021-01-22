<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Cotizacion;
use App\CotizacionDetalle;
use App\Producto;
use App\Secuencia;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::whereEstado(true)->orderByDesc('secuencia')->get();
        foreach ($cotizaciones as $c) {
            $c->cliente = $c->cliente;
        }
        return response()->json(['ok' => true, 'cotizaciones' => $cotizaciones]);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'fecha' => 'required',
            'nombre' => 'required',
            'identificador' => 'required',
            'valorsubtotal' => 'required',
            'valordescuento' => '',
            'descuento' => '',
            'valoriva' => 'required',
            'detalles' => 'required|array'

        ]);
        $cliente = isset($data['cliente']) ? $data['cliente'] : [];
        if (empty($cliente)) {
            $existeCliente = Cliente::where(['estado' => true, 'identificador' => $data['identificador']])->first();
            if (!$existeCliente) {
                $cliente = new Cliente();
                $cliente->nombre = $data['nombre'];
                $cliente->identificador = $data['identificador'];
                $cliente->save();
            } else {
                $cliente = $existeCliente;
            }
        }

        $cotizacion = new Cotizacion();
        $cotizacion->fecha = date('Y/m/d', strtotime($data['fecha']));
        $cotizacion->secuencia = str_pad(Secuencia::obtenerNumero('cotizacion'), 10, "0", STR_PAD_LEFT);;
        $cotizacion->cliente_id = $cliente['id'];
        $cotizacion->valortotal = $data['valortotal'];
        $cotizacion->valorsubtotal = $data['valorsubtotal'];
        $cotizacion->valordescuento = $data['valordescuento'];
        $cotizacion->descuento = $data['descuento'];
        $cotizacion->valoriva = $data['valoriva'];
        $cotizacion->save();
        foreach ($data['detalles'] as $d) {
            $detalle = new CotizacionDetalle();
            $detalle->cotizacion_id = $cotizacion->id;
            $detalle->producto_id = $d['producto_id'];
            $detalle->cantidad = $d['cantidad'];
            $detalle->valorunitario = $d['valorunitario'];
            $detalle->iva = $d['iva'];
            $detalle->descripcion = $d['descripcion'];
            $detalle->save();
        }
        return response()->json(['ok' => true, 'cotizacion' => $cotizacion, 'mensaje' => 'Cotizacion agregada.'], 200);
    }

    public function show($id)
    {
        $cotizacion = Cotizacion::find($id);
        $cotizacion->cliente = $cotizacion->cliente;
        $cotizacion->detalles = $cotizacion->detalles;
        // $cotizacion->detalles->producto = $cotizacion->detalles->producto;
        $i = 0;
        foreach ($cotizacion->detalles as $d) {
            $producto = Producto::find($d->producto_id);
            $cotizacion->detalles[$i]->producto = $producto;
            $i++;
        }
        return response()->json(['ok' => true, 'cotizacion' => $cotizacion]);
    }

    public function pdf($id)
    {
        $cotizacion = Cotizacion::detallesCompletos($id);
        $background = app('url')->asset('img/bg-cotiz.jpg');
        $pdf = app('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Styde.net</h1>');
        $pdf->loadView('pdfcotizacion', ['cotizacion' => $cotizacion, 'background' => $background]);
        return $pdf->download('cotizacion.pdf');
        // return $pdf->stream();
    }

    public function anular($id)
    {
        $cotizacion = Cotizacion::find($id);
        $cotizacion->anulado = true;
        $cotizacion->save();
        return response()->json(['ok' => true, 'mensaje' => 'Cotizacion anulada.', 'cotizacion' => $cotizacion]);
    }
}
