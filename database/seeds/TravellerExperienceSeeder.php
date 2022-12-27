<?php

use Illuminate\Database\Seeder;

class TravellerExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TravellerExperience::class, 30)->create();
    }
}
