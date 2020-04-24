<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('cod_art',10)->nullable();
            $table->string('art_nombreGenerico')->nullable();
            $table->string('art_nombreComercial')->nullable();
            $table->string('art_composicion')->nullable();
            $table->string('art_laboratorio')->nullable();
            $table->string('art_proveedor')->nullable();
            $table->string('art_descripcion')->nullable();
            $table->string('art_costoProveedor')->nullable();
            $table->string('art_costoVenta')->nullable();
            $table->string('art_accionTerapeutica')->nullable();

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
        Schema::dropIfExists('articulos');
    }
}
