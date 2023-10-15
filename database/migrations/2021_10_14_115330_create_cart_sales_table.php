<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCartSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->integer('product_count')->nullable();
            $table->decimal('discount', 10, 3)->nullable();
            $table->bigInteger('promo_code_id')->nullable();
            $table->string('orderNumber')->nullable();
            $table->string('orderId')->nullable();
            $table->decimal('sub_total', 10, 3);
            $table->decimal('total', 10, 3);
            $table->tinyInteger('status')->comment = '1 => Pendding || 2 => Accepted || 3 => Rejected';
            $table->tinyInteger('payment_status')->nullable()->comment = '1 => Pennding || 2 => Accepted || 3 => Rejected';
            $table->tinyInteger('delivery_status')->nullable()->comment = '1 => Pendding || 2 => Received || 3 => Not Received';
            $table->string('track_number')->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->string('apartment')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();
            $table->string('more_info')->nullable();
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
        Schema::dropIfExists('cart_sales');
    }
}
