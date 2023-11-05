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
        Schema::table('payment_wallet_orders', function (Blueprint $table) {
            $table->enum('type', ['western', 'wallet'])->default('wallet')->after('status');
            $table->string('country')->nullable()->after('status');
            $table->string('city')->nullable()->after('status');
            $table->string('name')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_wallet_orders', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('name');
        });
    }
};
