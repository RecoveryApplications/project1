<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->longText('title_ar');
            $table->longText('title_en');
            $table->longText('desc_ar');
            $table->longText('desc_en');
            $table->longText('slug_ar');
            $table->longText('slug_en');
            $table->longText('meta_desc_ar')->nullable();
            $table->longText('meta_desc_en')->nullable();
            $table->longText('seo_title_ar')->nullable();
            $table->longText('seo_title_en')->nullable();
            $table->longText('keywords_ar')->nullable();
            $table->longText('keywords_en')->nullable();
            $table->longText('tags')->nullable();
            $table->string('image');
            $table->tinyInteger('status')->comment = '1 => Active  || 2 => Not Active ';
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
        Schema::dropIfExists('blogs');
    }
};
