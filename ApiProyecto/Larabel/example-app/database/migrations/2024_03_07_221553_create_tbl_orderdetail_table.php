<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_orderdetail', function (Blueprint $table) {
            $table->integer('orderID')->index('orderid');
            $table->integer('orderDetailID', true);
            $table->integer('itemID')->index('itemid');
            $table->integer('quantity');
            $table->integer('mesaID')->index('mesaid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_orderdetail');
    }
};
