<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('image');
            $table->bigInteger('id_kategori')->unsigned();
            $table->integer('harga');
            $table->integer('harga_diskon');
            $table->string('info');
            $table->string('slug');
            $table->integer('status')->default(1)->comment('1 = aktif, 0 = nonaktif, 2 = delete');
            $table->timestamps();
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk');
    }
}
