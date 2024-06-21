<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMesaTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_mesa', function (Blueprint $table) {
            $table->increments('mesaID');
            $table->boolean('activate');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_mesa');
    }
}
