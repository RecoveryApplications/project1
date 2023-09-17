<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_sale_id')->constrained('cart_sales');
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('unit_price', 10, 3);
            $table->decimal('sub_total', 10, 3);
            $table->decimal('total', 10, 3);
            $table->bigInteger('quantity');
            $table->tinyInteger('property_type')->comment('1 = property || 2 = without property ');
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
        Schema::dropIfExists('cart_operations');
    }
}
