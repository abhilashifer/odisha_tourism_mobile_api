<?php

use Illuminate\Database\Seeder;

class MasterCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MasterCategory::class, 7)->create();
    }
}
