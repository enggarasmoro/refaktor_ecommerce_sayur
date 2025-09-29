<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('product_media')) {
            Schema::create('product_media', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('produk_id');
                $table->enum('type', ['image', 'video'])->default('image');
                $table->string('url');
                $table->unsignedSmallInteger('position')->default(0);
                $table->timestamps();

                $table->foreign('produk_id')->references('id')->on('produk')->onDelete('CASCADE');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_media');
    }
};
