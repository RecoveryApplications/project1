<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->longText('about_us_ar')->nullable();
            $table->longText('about_us_en')->nullable();
            $table->longText('vision_en')->nullable();
            $table->longText('vision_ar')->nullable();
            $table->longText('mission_en')->nullable();
            $table->longText('mission_ar')->nullable();
            $table->longText('about_us_image')->nullable();
            $table->longText('vision_image')->nullable();
            $table->longText('mission_image')->nullable();
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
        Schema::dropIfExists('about_us');
    }
}
