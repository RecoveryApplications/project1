<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            // Standard Fields :
            // ================================================================
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('country_key')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->text('profile_photo_path')->nullable();
            $table->tinyInteger('user_status')->comment = '1 => Pendding || 2 => Active || 3 => Inactive';

            // Other Fields :
            // ================================================================
            $table->foreignId('created_by')->constrained('users');


            // System Fields :
            // ================================================================
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
