<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('name')->nullable()->default('');
            $table->string('email')->nullable()->default('');
            $table->string('nohp')->nullable()->default('');
            $table->string('image')->nullable();
            $table->string('password');
            $table->integer('status')->default(1)->comment('1 = aktif, 0 = nonaktif, 2 = delete');
            $table->rememberToken();
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
        Schema::dropIfExists('admin');
    }
}
