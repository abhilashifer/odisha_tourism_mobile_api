<?php

use Illuminate\Database\Seeder;

class TouristDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TouristDestination::class, 100)->create();
    }
}
