<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';


    public function detalles()
    {
        return $this->hasMany('App\CotizacionDetalle');
    }
    public function cliente(){
        return $this->belongsTo('App\Cliente','cliente_id');
    }
    static function detallesCompletos($id){
        $cotizacion = Cotizacion::find($id);
        $cotizacion->cliente = $cotizacion->cliente;
        $cotizacion->detalles = $cotizacion->detalles;
        // $cotizacion->detalles->producto = $cotizacion->detalles->producto;
        $i=0;
        foreach($cotizacion->detalles as $d){
            $producto = Producto::find($d->producto_id);
            $cotizacion->detalles[$i]->producto = $producto;
            $i++;
        }
        return $cotizacion;
    }
}
