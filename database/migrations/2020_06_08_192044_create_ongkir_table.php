<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOngkirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ongkir', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('min_trans');
            $table->integer('ongkir');
            $table->integer('status')->default(1)->comment('1 = aktif, 0 = nonaktif, 2 = delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ongkir');
    }
}
