<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTouristDestinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourist_destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trip_type')->nullable();
            $table->text('loc_cord')->nullable();
            $table->text('thumbnail');
            $table->text('address');
            $table->foreignId('district_id')->comment('id from t_district');
            $table->foreignId('destination_category_id')->comment('id from m_attraction_category');
            $table->text('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('website')->nullable();
            $table->text('des_short');
            $table->text('des_long')->nullable();



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
        Schema::dropIfExists('tourist_destination');
    }
}
