<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;
    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'sliders';
    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'image',
        'status',
        'created_by',
    ];


    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================
    // Relation With Product Model
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================
    public function getStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Active';
        } elseif ($value == 2) {
            return 'Inactive';
        }
    }


    public function getTitleAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->title_en}";
        }
        else{
            return "{$this->title_ar}";
        }
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
}
