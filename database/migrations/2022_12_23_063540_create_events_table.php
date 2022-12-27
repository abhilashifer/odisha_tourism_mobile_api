<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_subcategory_id');
            $table->foreignId('district_id')->comment('id from t_district');
            $table->string('name');
            $table->text('event_address');
            $table->date('from_date');
            $table->date('to_date');
            $table->time('from_time');
            $table->time('to_time');
            $table->text('loc_cord');
            $table->string('mobile_number')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('des_short');
            $table->text('des_long');
            $table->text('thumbnail');
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
        Schema::dropIfExists('events');
    }
}
