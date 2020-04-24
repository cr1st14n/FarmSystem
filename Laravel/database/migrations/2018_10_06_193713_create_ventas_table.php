<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            //datos de la venta
            $table->string('vent_canTipoArticulos',20)->nullable();
            $table->string('vent_canArticulosTotal',20)->nullable();
            $table->string('vent_efectivo',20)->nullable();
            
            //datos del cliente
            $table->string('vent_clienteNombre',20)->nullable();
            $table->string('vent_clienteNit',20)->nullable();

            //datos CA
            $table->integer('ca_cod_usu')->nullable();
            $table->string('ca_tipo',20)->nullable();
            $table->dateTime('ca_fecha')->nullable();
            $table->integer('ca_estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
