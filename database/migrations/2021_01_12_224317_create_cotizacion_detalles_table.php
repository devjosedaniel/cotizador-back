<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cotizacion_id')->unsigned()->nullable(false);
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones');
            $table->bigInteger('producto_id')->unsigned()->nullable(false);
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->string('descripcion')->nullable(true);
            $table->integer('cantidad')->nullable(false);
            $table->integer('iva')->nullable(false);
            $table->integer('valorunitario')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizacion_detalles');
    }
}
