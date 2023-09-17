<?php

namespace Database\Seeders;

use App\Models\PublicValue;
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
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            AboutUsSeeder::class,
            ContactUsSeeder::class,
            SeoOperationsSeeder::class,
            CategoriesSeeder::class,
            ProductSeed::class,
            PublicValuesSeeder::class
        ]);
    }
}
