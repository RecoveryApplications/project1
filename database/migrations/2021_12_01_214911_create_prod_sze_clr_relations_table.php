<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdSzeClrRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_sze_clr_relations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('main_size_id')->nullable();
            $table->bigInteger('main_color_id')->nullable();
            $table->bigInteger('product_id');
            // $table->decimal('weight', 10, 2)->nullable();
            // $table->tinyInteger('weight_unit')->nullable()->comment("1 => G || 2 => KG || 3=> piece");
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->tinyInteger('on_sale_price_status')->nullable()->comment = '1 => Active || 2 => Inactive';
            $table->decimal('on_sale_price', 10, 2)->nullable();
            $table->integer('quantity_available')->nullable();
            $table->integer('quantity_limit')->nullable();
            $table->longText('image')->nullable();
            $table->longText('image_url')->nullable();
            $table->tinyInteger('status')->nullable()->comment = '1 => Active || 2 => Inactive';
            $table->bigInteger('updated_by');
            $table->softDeletes();
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
        Schema::dropIfExists('prod_sze_clr_relations');
    }
}
