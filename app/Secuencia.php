<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secuencia extends Model
{
    protected $table = 'secuencias';

    protected $fillable = [
        'nombre', 'numero',
    ];
    static function obtenerNumero($nombre)
    {
        $secuencia = Secuencia::where('nombre', $nombre)->first();
        if($secuencia){
            $secuencia->numero = $secuencia->numero + 1;
            $secuencia->save();
        }else{
            $secuencia = Secuencia::create(['nombre'=>$nombre, 'numero'=> 1]);
        }
        return $secuencia->numero;
    }
}
