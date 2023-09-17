<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('main_category_id');
            $table->bigInteger('sub_category_id')->nullable();
            $table->longText('name_ar')->nullable();
            $table->longText('name_en')->nullable();
            $table->longText('main_description_ar')->nullable();
            $table->longText('main_description_en')->nullable();
            $table->longText('sub_description_ar')->nullable();
            $table->longText('sub_description_en')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->tinyInteger('weight_unit')->nullable()->comment("1 => G || 2 => KG || 3=> piece");
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->tinyInteger('on_sale_price_status')->nullable()->comment = '1 => Active || 2 => Inactive';
            $table->decimal('on_sale_price', 10, 2)->nullable();
            $table->integer('quantity_available')->nullable();
            $table->integer('quantity_limit')->nullable();
            $table->longText('image')->nullable();
            $table->longText('image_url')->nullable();
            $table->longText('private_info')->nullable();
            $table->tinyInteger('status')->nullable()->comment = '1 => Active || 2 => Inactive';
            $table->tinyInteger('gender')->nullable()->comment = '1 => male || 2 => female';
            $table->string('featured_flag')->nullable();
            $table->bigInteger('updated_by');
            $table->bigInteger('brand_id')->nullable();
            $table->bigInteger('color_id')->nullable();
            $table->bigInteger('size_id')->nullable();
            $table->longText('slug_ar')->nullable();
            $table->longText('slug_en')->nullable();
            $table->longText('meta_desc_ar')->nullable();
            $table->longText('meta_desc_en')->nullable();
            $table->longText('seo_title_ar')->nullable();
            $table->longText('seo_title_en')->nullable();
            $table->longText('keywords_ar')->nullable();
            $table->longText('keywords_en')->nullable();
            $table->longText('tags')->nullable();
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
        Schema::dropIfExists('products');
    }
}
