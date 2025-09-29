<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('id_user')->nullable()->default('Guest');
            $table->ipAddress('ipaddress');
            $table->string('nama');
            $table->string('email');
            $table->string('nohp');
            $table->text('alamat');
            $table->string('kota');
            $table->string('kodepos')->nullable()->default(null);
            $table->string('id_voucher')->nullable()->default(null);
            $table->string('id_bank');
            $table->integer('total');
            $table->integer('kode_unik');
            $table->integer('status')->default(1)->comment('0 = On Hold,1 = Proses,2 = Complete, 3 = remove');
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
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
        Schema::dropIfExists('order');
    }
}
