<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{


    protected $table = 'clientes';

    public function cotizaciones(){
        return $this->hasMany('App\Cotizacion');
    }
}
