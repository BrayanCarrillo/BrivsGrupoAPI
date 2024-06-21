<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMenuTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_menu', function (Blueprint $table) {
            $table->increments('menuID');
            $table->string('menuName', 25);
            $table->boolean('activate');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_menu');
    }
}
