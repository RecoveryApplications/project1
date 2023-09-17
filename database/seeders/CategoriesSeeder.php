<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MainCategory;
use App\Models\SuperCategory;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
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
                "Fashion",
                "Main category" => "Fashion"
            ],
            [
                "Linen",
                "Main category" => "Linen"
            ],
            [
                "Jumpsuit",
                "Main category" => "Jumpsuit"
            ]
        ];

        foreach ($array as $arr) {




                $main = MainCategory::create([
                    'name_en' => $arr['Main category'],
                    'status' => 1,
                    'updated_by' => 1,
                ]);

                if (isset($arr['sub categoty']) && $arr['sub categoty'] != null) {
                    Category::create([
                        'name_en' => $arr['sub categoty'],
                        'status' => 1,
                        'updated_by' => 1,
                        'main_category_id' => $main->id
                    ]);
                }
            }
        }
    }

