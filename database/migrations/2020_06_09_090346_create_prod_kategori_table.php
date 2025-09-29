<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdKategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_kategori', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_kategori')->unsigned();
            $table->bigInteger('id_produk')->unsigned();
            $table->timestamps();
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('CASCADE');
            $table->foreign('id_produk')->references('id')->on('produk')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_kategori');
    }
}
