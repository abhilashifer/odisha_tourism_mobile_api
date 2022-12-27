<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TouristDestinationTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DB::table('tourist_destinations_tours')->get(), 100)->create();
    }
}
