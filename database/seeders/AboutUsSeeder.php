<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AboutUs::create([
            'about_us_en' => "Writing about us information in English ",
            'vision_en' => "Writing our vision information in English ",
            'mission_en' => "Writing our mission information in English",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
