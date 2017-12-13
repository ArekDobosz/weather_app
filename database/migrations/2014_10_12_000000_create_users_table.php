<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->integer('place_id');
            $table->decimal('max_temperature', 5, 2)->nullable();
            $table->decimal('min_temperature', 5, 2)->nullable();
            $table->integer('max_humidity')->nullable();
            $table->integer('min_humidity')->nullable();
            $table->decimal('wind', 5, 2)->nullable();
            $table->integer('radiation')->nullable();
            $table->string('token')->nullable();
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
        Schema::dropIfExists('users');
    }
}
