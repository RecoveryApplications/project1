<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;


class Blogs extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "blogs";
    protected $fillable = [
        'user_id',
        'title_ar',
        'title_en',
        'desc_ar',
        'desc_en',
        'slug_ar',
        'slug_en',
        'image',
        'status',
        'seo_title_ar',
        'seo_title_en',
        'keywords_ar',
        'keywords_en',
        'meta_desc_ar',
        'meta_desc_en',
        'tags',
    ];

    protected $date = ['deleted_at'];





    public function getSlugAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->slug_en}";
        }
        else{
            return "{$this->slug_ar}";
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
            return "{$this->desc_en}";
        }
        else{
            return "{$this->desc_ar}";
        }
    }

    public function getDayAttribute(){
        return date('d',strtotime($this->created_at));
    }

    public function getMonthAndYearAttribute(){
        return date('M Y',strtotime($this->created_at));
    }
    public function getMonthAndDayAttribute(){
        return date('M d',strtotime($this->created_at));
    }
    public function getYearAttribute(){
        return date('Y',strtotime($this->created_at));
    }


    // ================================
    // Relations
    // ================================
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
