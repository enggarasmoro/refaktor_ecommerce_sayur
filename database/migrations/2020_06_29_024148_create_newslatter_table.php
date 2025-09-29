<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewslatterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newslatter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keterangan');
            $table->string('image');
            $table->enum('status', ['1', '0'])->default('1')->comment('1 = aktif, 0 = nonaktif');
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
        Schema::dropIfExists('newslatter');
    }
}
