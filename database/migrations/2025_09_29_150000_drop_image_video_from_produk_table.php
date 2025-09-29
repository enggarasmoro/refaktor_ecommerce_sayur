<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (Schema::hasColumn('produk','image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('produk','video_url')) {
                $table->dropColumn('video_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk','image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('produk','video_url')) {
                $table->string('video_url')->nullable();
            }
        });
    }
};
