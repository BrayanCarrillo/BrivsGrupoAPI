<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrderTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_order', function (Blueprint $table) {
            $table->increments('orderID');
            $table->text('status');
            $table->decimal('total', 15, 2);
            $table->date('order_date');
            $table->integer('mesaID')->unsigned();
            $table->foreign('mesaID')->references('mesaID')->on('tbl_mesa');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_order');
    }
}
