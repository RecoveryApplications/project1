<?php

namespace Database\Seeders;

use App\Models\PublicValue;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PublicValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [
                "title"=>"Color",
                "values"=>2
            ],
            [
                "title"=>"Size",
                "values"=>2
            ]
            ,
            [
                "title"=>"Tax",
                "values"=>0
            ]
        ];
        foreach ($array as $arr) {
        PublicValue::create([
            'title' => $arr['title'],
            'values' => $arr['values'],
        ]);
    }
    }
}
