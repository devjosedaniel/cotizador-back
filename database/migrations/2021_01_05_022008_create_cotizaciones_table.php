<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->useCurrent();
            $table->boolean('anulado')->default(false);
            $table->bigInteger('cliente_id')->unsigned()->nullable(false);
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->decimal('valorsubtotal',5,2)->nullable(false);
            $table->decimal('descuento',5,2)->nullable(true);
            $table->decimal('valordescuento',5,2)->nullable(true);
            $table->decimal('valoriva',5,2)->nullable(true);
            $table->decimal('valortotal',5,2)->nullable(false);
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('cotizaciones');
    }
}
