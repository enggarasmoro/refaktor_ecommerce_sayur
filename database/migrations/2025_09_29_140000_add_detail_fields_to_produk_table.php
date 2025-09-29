<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk','description')) {
                $table->text('description')->nullable()->after('info');
            }
            if (!Schema::hasColumn('produk','origin')) {
                $table->string('origin')->nullable()->after('description');
            }
            if (!Schema::hasColumn('produk','brochure_image')) {
                $table->string('brochure_image')->nullable()->after('origin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (Schema::hasColumn('produk','brochure_image')) {
                $table->dropColumn('brochure_image');
            }
            if (Schema::hasColumn('produk','origin')) {
                $table->dropColumn('origin');
            }
            if (Schema::hasColumn('produk','description')) {
                $table->dropColumn('description');
            }
        });
    }
};
