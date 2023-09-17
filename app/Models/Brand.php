<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';


    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
        'status',
        'main_category_id'
    ];



    // relation with super categories table
    // by : Mohammed Salah
    public function mainCategory(){
        return $this->belongsTo(MainCategory::class,'main_category_id');
    }


    // relation with Products table
    // by : Mohammed Salah
    public function products(){
        return $this->hasMany(Product::class,'brand_id');
    }

    public function getNameAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->name_en}";
        }
        else{
            return "{$this->name_ar}";
        }
    }

}
