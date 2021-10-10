<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Admin::factory(1)->create();
        \App\Models\Branch::factory(1)->create();
        \App\Models\GeneralSetting::factory(1)->create();
        \App\Models\Supplier::factory(100)->create();
        \App\Models\SupplierBank::factory(100)->create();
        \App\Models\Category::factory(1000)->create();
        \App\Models\Product::factory(10000)->create();
        \App\Models\Size::factory(100000)->create();

    }
}
