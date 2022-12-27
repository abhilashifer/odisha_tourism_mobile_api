<?php

use Illuminate\Database\Seeder;

class AccomodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Accomodation::class, 100)->create();
    }
}
