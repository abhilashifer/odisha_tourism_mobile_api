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
        Schema::create('tourist_destination', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trip_type')->nullable();
            $table->text('loc_cord')->nullable();
            $table->text('thumbnail');
            $table->text('address');
            $table->foreignId('district_id')->references('intDistrictId')->on('t_district');
            $table->foreignId('destination_category_id')->references('intCatId')->on('m_attractions_category');
            $table->text('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('website')->nullable();
            $table->text('short_des');
            $table->text('description')->nullable();



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
