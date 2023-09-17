<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\MainColor;
use App\Models\MainSize;
use App\Models\Product;
use App\Models\SuperCategory;
use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
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
                "Name" => "Lima dress",
                "Column2" => "Electronics",
                "Other",
                "Main Category" => "Fashion",
                "Sub Category" => null,
                "Brand" => "Stelle",
                "Sale Price" => 119,
                "On Sale Price Status" => "inactive",
                "On Sale Price" => null,
                "Available Quantity" => 1,
                "Featured Flag" => null,
                "Main Description" => "",
                "Status " => "active"
            ],
            [
                "Name" => "Pink Linen Wrap top & skirt set",
                "Column2" => "Electronics",
                "Other",
                "Main Category" => "Linen",
                "Sub Category" => null,
                "Brand" => "Stelle",
                "Sale Price" => 200,
                "On Sale Price Status" => "inactive",
                "On Sale Price" => null,
                "Available Quantity" => 1,
                "Featured Flag" => null,
                "Main Description" => "",
                "Status " => "active",
            ],
            [
                "Name" => "Feathered Wrap Jumpsuit",
                "Column2" => "Electronics",
                "Other",
                "Main Category" => "Jumpsuit",
                "Sub Category" => null,
                "Brand" => "Stelle",
                "Sale Price" => 200,
                "On Sale Price Status" => "inactive",
                "On Sale Price" => null,
                "Available Quantity" => 1,
                "Featured Flag" => null,
                "Main Description" => "",
                "Status " => "active",
            ],
        ];



        foreach($array as $arr){
                $main = MainCategory::where('name_en',$arr['Main Category'])->first();
                if($main){
                    if($arr['Sub Category'] != null){
                        $sub = Category::where('name_en',$arr['Sub Category'])->first();
                        if($sub){
                            $brand = Brand::where('name_en',$arr['Brand'])->first();
                            if($brand){
                                if($arr['Size'] != null){
                                    $size = MainSize::where('name_en',$arr['Size'])->first();
                                }
                                if($arr['Color'] != null){
                                    $color = MainColor::where('name_en',$arr['Color'])->first();
                                }

                                Product::create([
                                    'main_category_id' => $main->id,
                                    'sub_category_id' => $sub->id,
                                    'name_en' => $arr['Name'],
                                    'main_description_en' => $arr['Main Description'],
                                    'sale_price' => $arr['Sale Price'],
                                    'on_sale_price_status' => 2,
                                    'on_sale_price' => 0,
                                    'quantity_available' => $arr['Available Quantity'],
                                    'image' => null,
                                    'image_url' => $arr['Image URL'],
                                    'status' => 1,
                                    'updated_by' => 1,
                                    'brand_id' => $brand->id,
                                    'size_id' => isset($size->id) ? $size->id : null,
                                    'color_id' => isset($color->id) ? $color->id : null,
                                ]);


                            }else{

                                if($arr['Size'] != null){
                                    $size = MainSize::where('name_en',$arr['Size'])->first();
                                }
                                if($arr['Color'] != null){
                                    $color = MainColor::where('name_en',$arr['Color'])->first();
                                }

                                Product::create([
                                    'main_category_id' => $main->id,
                                    'sub_category_id' => $sub->id,
                                    'name_en' => $arr['Name'],
                                    'main_description_en' => $arr['Main Description'],
                                    'sale_price' => $arr['Sale Price'],
                                    'on_sale_price_status' => 2,
                                    'on_sale_price' => 0,
                                    'quantity_available' => $arr['Available Quantity'],
                                    'image' => null,
                                    'image_url' => $arr['Image URL'],
                                    'status' => 1,
                                    'updated_by' => 1,
                                    'size_id' => isset($size->id) ? $size->id : null,
                                    'color_id' => isset($color->id) ? $color->id : null,
                                ]);

                            }
                        }else{

                            $brand = Brand::where('name_en',$arr['Brand'])->first();
                            if($brand){
                                if($arr['Size'] != null){
                                    $size = MainSize::where('name_en',$arr['Size'])->first();
                                }
                                if($arr['Color'] != null){
                                    $color = MainColor::where('name_en',$arr['Color'])->first();
                                }

                                Product::create([
                                    'main_category_id' => $main->id,
                                    'name_en' => $arr['Name'],
                                    'main_description_en' => $arr['Main Description'],
                                    'sale_price' => $arr['Sale Price'],
                                    'on_sale_price_status' => 2,
                                    'on_sale_price' => 0,
                                    'quantity_available' => $arr['Available Quantity'],
                                    'image' => null,
                                    'image_url' => $arr['Image URL'],
                                    'status' => 1,
                                    'updated_by' => 1,
                                    'brand_id' => $brand->id,
                                    'size_id' => isset($size->id) ? $size->id : null,
                                    'color_id' => isset($color->id) ? $color->id : null,
                                ]);


                            }else{

                                if($arr['Size'] != null){
                                    $size = MainSize::where('name_en',$arr['Size'])->first();
                                }
                                if($arr['Color'] != null){
                                    $color = MainColor::where('name_en',$arr['Color'])->first();
                                }

                                Product::create([
                                    'main_category_id' => $main->id,
                                    'name_en' => $arr['Name'],
                                    'main_description_en' => $arr['Main Description'],
                                    'sale_price' => $arr['Sale Price'],
                                    'on_sale_price_status' => 2,
                                    'on_sale_price' => 0,
                                    'quantity_available' => $arr['Available Quantity'],
                                    'image' => null,
                                    'image_url' => $arr['Image URL'],
                                    'status' => 1,
                                    'updated_by' => 1,
                                    'size_id' => isset($size->id) ? $size->id : null,
                                    'color_id' => isset($color->id) ? $color->id : null,
                                ]);

                            }

                        }
                    }
                }
        }
    }
}
