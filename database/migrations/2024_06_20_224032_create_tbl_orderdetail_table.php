<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrderdetailTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_orderdetail', function (Blueprint $table) {
            $table->increments('orderDetailID');
            $table->integer('orderID')->unsigned();
            $table->integer('itemID')->unsigned();
            $table->integer('quantity');
            $table->integer('mesaID')->unsigned()->nullable();
            $table->foreign('orderID')->references('orderID')->on('tbl_order')->onDelete('cascade');
            $table->foreign('itemID')->references('itemID')->on('tbl_menuitem');
            $table->foreign('mesaID')->references('mesaID')->on('tbl_mesa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_orderdetail');
    }
}
