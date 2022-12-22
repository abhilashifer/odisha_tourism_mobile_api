<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomodation_master', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('accomodation_cat_id')->references('intCategoryId')->on('t_accommodation_category');
            $table->foreignId('district_id')->references('intDistrictId')->on('t_district');
            $table->text('thumbnail');
            $table->text('address');
            $table->text('des_short');
            $table->text('des_long');
            $table->text('loc_code')->nullable();
            $table->integer('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();



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
        Schema::dropIfExists('accomodation_master');
    }
}
