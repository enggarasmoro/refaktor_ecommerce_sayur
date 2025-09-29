<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'video_url')) {
                $table->string('video_url')->nullable()->after('image');
            }
            if (!Schema::hasColumn('produk', 'stok')) {
                $table->integer('stok')->default(0)->after('harga_diskon');
            }
            if (!Schema::hasColumn('produk', 'discount_percent')) {
                $table->unsignedTinyInteger('discount_percent')->nullable()->after('harga_diskon');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (Schema::hasColumn('produk', 'video_url')) {
                $table->dropColumn('video_url');
            }
            if (Schema::hasColumn('produk', 'stok')) {
                $table->dropColumn('stok');
            }
            if (Schema::hasColumn('produk', 'discount_percent')) {
                $table->dropColumn('discount_percent');
            }
        });
    }
};
