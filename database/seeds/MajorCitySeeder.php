<?php

use Illuminate\Database\Seeder;
use App\MajorCity;

class MajorCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MajorCity::class, 30)->create();
    }
}
