<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class MainCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "main_categories";
    protected $guarded = [];


    protected $date = ['deleted_at'];


    //=====================================================================================
    //============================== Relations ============================================
    //=====================================================================================



    // relation with users table
    // by : Mohammed Salah
    public function user(){
        return $this->belongsTo(User::class,'updated_by');
    }




    // relation with sub categories table
    // by : Mohammed Salah
    public function subCategories(){
        return $this->hasMany(Category::class,'main_category_id')->where('status',1);
    }


    // relation with products table
    // by : Mohammed Salah
    public function products(){
        return $this->hasMany(Product::class,'main_category_id')->where('status',1);
    }
       // relation with products table
    // by : Mohammed Salah
    public function brands(){
        return $this->hasMany(Brand::class,'main_category_id');
    }

    public function getDescriptionAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->description_en}";
        }
        else{
            return "{$this->description_ar}";
        }
    }



    public function getNameAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->name_en}";
        }
        else{
            return $this->name_ar ?? $this->name_en;
        }
    }
}
