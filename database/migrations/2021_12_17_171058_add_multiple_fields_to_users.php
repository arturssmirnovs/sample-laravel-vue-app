<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('gender_id')->nullable()->references('id')->on('genders');
            $table->foreignId('timezone_id')->nullable()->references('id')->on('timezones');
            $table->foreignId('country_id')->nullable()->references('id')->on('countries');
            $table->foreignId('language_id')->nullable()->references('id')->on('languages');

            $table->text('bio')->nullable();

            $table->string('picture')->nullable();

            $table->json('notifications')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
