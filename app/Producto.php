<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{


    protected $table = 'productos';
    public function categoria()
    {
        return $this->belongsTo('App\Categoria', 'categoria_id');
    }
    public function detalles(){
        return $this->hasMany(CotizacionDetalle::class);
    }
}
