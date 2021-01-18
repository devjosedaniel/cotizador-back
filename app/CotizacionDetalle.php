<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    protected $table = 'cotizacion_detalles';


    public function cotizacion()
    {
        return $this->belongsTo('App\Cotizacion','cotizacion_id');
    }
    public function producto(){
        return $this->belongsTo('App\Producto', 'producto_id');
    }
}
