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
        Schema::table('tbl_orderdetail', function (Blueprint $table) {
            $table->foreign(['mesaID'], 'fk_mesaID')->references(['mesaID'])->on('tbl_mesa')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_orderdetail', function (Blueprint $table) {
            $table->dropForeign('fk_mesaID');
        });
    }
};
