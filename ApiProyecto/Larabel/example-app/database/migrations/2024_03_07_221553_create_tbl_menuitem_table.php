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
        Schema::create('tbl_menuitem', function (Blueprint $table) {
            $table->integer('itemID', true);
            $table->integer('menuID')->index('menuid');
            $table->text('menuItemName');
            $table->decimal('price', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_menuitem');
    }
};
