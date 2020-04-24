<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFechvencimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechvencimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('cod_art')->nullable();
            $table->date('fv_fechavencimiento')->nullable();
            $table->int('fv_estado')->nullable();

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
        Schema::dropIfExists('fechvencimientos');
    }
}
