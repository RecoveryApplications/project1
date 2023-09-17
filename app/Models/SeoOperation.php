<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class SeoOperation extends Model
{
    use HasFactory;

    protected $table = 'seo_operations';
    protected $fillable = [
        'user_id',
        'user_type',
        'page_name',
        'seo_title_ar',
        'seo_title_en',
        'meta_desc_ar',
        'meta_desc_en',
        'keywords_ar',
        'keywords_en',
        'redirect_301_ar',
        'redirect_301_en',
        'h1_val_en',
        'h1_val_ar',
        'h2_val_en',
        'h2_val_ar',
    ];


    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================


    public function getSeoTitleAttribute()
    {

        if (Config::get('app.locale') == 'en'){
            if($this->seo_title_en != null){
                return "{$this->seo_title_en}";
            }else{
                return null;
            }
        }
        else{
            if($this->seo_title_ar != null){
                return "{$this->seo_title_ar}";
            }else{
                return null;
            }
        }
    }



    public function getKeywordsAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->keywords_en}";
        }
        else{
            return "{$this->keywords_ar}";
        }
    }



    public function getRedirect_301Attribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->redirect_301_en}";
        }
        else{
            return "{$this->redirect_301_ar}";
        }
    }



    public function getMetaDescAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            if($this->meta_desc_en != null){
                return "{$this->meta_desc_en}";
            }else{
                return null;
            }
        }
        else{
            if($this->meta_desc_ar != null){
                return "{$this->meta_desc_ar}";
            }else{
                return null;
            }
        }

    }
    public function getH1ValAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->h1_val_en}";
        }
        else{
            return "{$this->h1_val_ar}";
        }
    }
    public function getH2ValAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->h2_val_en}";
        }
        else{
            return "{$this->h2_val_ar}";
        }
    }

}
