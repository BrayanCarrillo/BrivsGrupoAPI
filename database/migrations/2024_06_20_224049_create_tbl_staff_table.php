<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblStaffTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_staff', function (Blueprint $table) {
            $table->increments('staffID');
            $table->string('username', 25);
            $table->string('password', 100);
            $table->boolean('status');
            $table->string('role', 25);
            $table->foreign('role')->references('role')->on('tbl_role');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_staff');
    }
}
