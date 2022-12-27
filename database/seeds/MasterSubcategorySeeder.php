<?php

use Illuminate\Database\Seeder;

class MasterSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MasterSubcategory::class, 50)->create();
    }
}
