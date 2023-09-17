<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SeoOperation;
use Carbon\Carbon;

class SeoOperationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeoOperation::create([
            'user_id'=>1,
            'user_type'=>'Super Admin',
            'page_name'=>'Welcome',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        SeoOperation::create([
            'user_id'=>1,
            'user_type'=>'Super Admin',
            'page_name'=>'About Us',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        SeoOperation::create([
            'user_id'=>1,
            'user_type'=>'Super Admin',
            'page_name'=>'Contact Us',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        SeoOperation::create([
            'user_id'=>1,
            'user_type'=>'Super Admin',
            'page_name'=>'Shop',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        SeoOperation::create([
            'user_id'=>1,
            'user_type'=>'Super Admin',
            'page_name'=>'Blogs',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

    }
}
