<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_subcategory_id');
            $table->foreignId('district_id')->comment('id from t_district');
            $table->string('name');
            $table->string('tour_from')->nullable();
            $table->string('tour_to')->nullable();
            $table->text('thumbnail')->nullable();
            $table->text('des_short');
            $table->text('des_long');
            $table->text('loc_cord');
            $table->text('additional_info')->nullable();
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
        Schema::dropIfExists('tours');
    }
}
