<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cart_sales', function (Blueprint $table) {
            $table->double('shipping')->default(0)->after('total');
            $table->double('sale_percentage')->default(0)->after('shipping');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_sales', function (Blueprint $table) {
            $table->dropColumn('shipping');
            $table->dropColumn('sale_percentage');
        });
    }
};
