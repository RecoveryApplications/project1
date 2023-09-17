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
        Schema::table('categories', function (Blueprint $table) {
            $table->longText('slug_ar')->nullable();
            $table->longText('slug_en')->nullable();
            $table->longText('meta_desc_ar')->nullable();
            $table->longText('meta_desc_en')->nullable();
            $table->longText('seo_title_ar')->nullable();
            $table->longText('seo_title_en')->nullable();
            $table->longText('keywords_ar')->nullable();
            $table->longText('keywords_en')->nullable();
            $table->longText('tags')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
};
