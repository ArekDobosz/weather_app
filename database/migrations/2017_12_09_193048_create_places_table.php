<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lat')->default('0');
            $table->string('lng')->default('0');
            $table->decimal('temperature', 5, 2)->default(0);
            $table->integer('humidity')->default(0);
            $table->decimal('wind', 5, 2)->default(0);
            $table->integer('radiation')->default(0);
            $table->string('icon')->default('');
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
        Schema::dropIfExists('places');
    }
}
