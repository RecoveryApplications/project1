<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class AboutUs extends Model
{
    use HasFactory;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'about_us';
    protected $fillable = [
        'about_us_ar',
        'about_us_en',
        'vision_en',
        'vision_ar',
        'mission_en',
        'mission_ar',
        'about_us_image',
        'vision_image',
        'mission_image',
    ];


    public function getAboutUsAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->about_us_en}";
        }
        else{
            return "{$this->about_us_ar}";
        }
    }

    public function getVisionAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->vision_en}";
        }
        else{
            return "{$this->vision_ar}";
        }
    }

    public function getMissionAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->mission_en}";
        }
        else{
            return "{$this->mission_ar}";
        }
    }
}
