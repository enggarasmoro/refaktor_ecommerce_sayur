<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nohp')->unique();
            $table->string('alamat')->nullable()->default('');
            $table->string('kota')->nullable()->default('');
            $table->string('kodepos')->nullable()->default('');
            $table->string('image')->nullable();
            $table->integer('status')->default(1)->comment('1 = aktif, 0 = nonaktif, 2 = delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
