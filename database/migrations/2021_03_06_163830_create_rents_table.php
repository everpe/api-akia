<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('cellphone', 255);
            $table->string('email');
            //numero de giro comercial
            $table->string('turn_number')->nullable();
            //numero de franquicia
            $table->string('franchise_number')->nullable();
            //metros cuadrados requeridos
            $table->string('square_meters_required')->nullable();
            $table->string('type');
            //resulta o sin resolver
            $table->boolean('state')->default(true);           
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
        Schema::dropIfExists('rents');
    }
}
