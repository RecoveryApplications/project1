<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'products';
    protected $fillable = [
        'super_category_id',
        'main_category_id',
        'sub_category_id',
        'name_en',
        'name_ar',
        'main_description_en',
        'main_description_ar',
        'sub_description_en',
        'sub_description_ar',
        'weight',
        'sale_price',
        'on_sale_price_status',
        'on_sale_price',
        'quantity_available',
        'quantity_limit',
        'image',
        'image_url',
        'status',
        'updated_by',
        'weight_unit',
        'featured_flag',
        'brand_id',
        'color_id',
        'size_id',
        'private_info',
        'weight',
        'gender',
        'slug_ar',
        'slug_en',
        'seo_title_ar',
        'seo_title_en',
        'keywords_ar',
        'keywords_en',
        'meta_desc_ar',
        'meta_desc_en',
        'tags',
    ];


    protected $date = ['deleted_at'];


    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================


    // relation with users table
    // by : Mohammed Salah
    public function user(){
        return $this->belongsTo(User::class,'updated_by');
    }

    // relation with Color table
    // by : Mohammed Salah
    public function  productColor(){
        return $this->belongsTo(MainColor::class,'color_id');
    }

    // relation with Size table
    // by : Mohammed Salah
    public function  productSize(){
        return $this->belongsTo(MainSize::class,'size_id');
    }

    // relation with super categories table
    // by : Mohammed Salah
    public function superCategory(){
        return $this->belongsTo(SuperCategory::class,'super_category_id')->where('status',1);
    }

    // relation with main categories table
    // by : Mohammed Salah
    public function mainCategory(){
        return $this->belongsTo(MainCategory::class,'main_category_id')->where('status',1);
    }

    // relation with main categories table
    // by : Mohammed Salah
    public function subCategory(){
        return $this->belongsTo(Category::class,'sub_category_id')->where('status',1);
    }


    // Relation With ProductImage Model :
    public function productImages()
    {
        return $this->hasMany(ProductImage::class,'product_id');
    }


    // Relation With CartOperation Model :
    public function cartOperations()
    {
        return $this->hasMany(CartOperation::class, 'product_id')->where('property_type','!=',1);
    }

    // Relation With ProductReview Table
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    // Relation With ProductReview Table
    public function productReviewByCustomer()
    {
        return $this->hasMany(ProductReview::class, 'product_id')->where(['user_id' => auth()->user()->id, 'user_type' => 'Customer']);
    }

    // Relation With ProductWishlist Model :
    public function checkWishlistByAuthUser()
    {
        return $this->hasMany(ProductWishlist::class)->where(['customer_id' => auth()->user()->id]);
    }

    // Relation With ProdSzeClrRelation Model :
    public function properties()
    {
        return $this->hasMany(ProdSzeClrRelation::class,'product_id')->where('status',1);
    }

    // First property
    public function firstProperty()
    {
       return $this->hasOne(ProdSzeClrRelation::class)->where('status',1)->orderBy('id', 'desc');
    }

    // Brand
    public function brand()
    {
       return $this->belongsTo(Brand::class,'brand_id');
    }
    // Brand
    public function offer()
    {
       return $this->belongsTo(Offer::class,'offer_id');
    }

    // Rates Users product
    public function review()
    {
        return $this->hasMany(Review::class, 'product_id');
    }


    // Product Colors
    public function colors()
    {
        return $this->hasMany(ProdSzeClrRelation::class, 'product_id')->where('status',1)->where('main_color_id','!=',null)->orderBy('created_at','desc');
    }

    // Product Sizes
    public function sizes()
    {
        return $this->hasMany(ProdSzeClrRelation::class, 'product_id')->where('status',1)->where('main_size_id','!=',null)->orderBy('created_at','desc');
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
    public function getOnSalePriceStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Active';
        } elseif ($value == 2) {
            return 'Inactive';
        }
    }
    public function getWeightUnitAttribute($value)
    {
        if ($value == 1) {
            return 'ML';
        } elseif ($value == 2) {
            return 'KG';
        } elseif ($value == 3) {
            return 'G';
        }
    }

    public function getGenderAttribute($value)
    {
        if ($value == 1) {
            return 'Male';
        } elseif ($value == 2) {
            return 'Female';
        }
    }

    public function getNameAttribute()
    {
        if (Config::get('app.locale') == 'en') {
            return "{$this->name_en}";
        } else {
            return "{$this->name_ar}";
        }
    }



    public function getMainDescriptionAttribute()
    {
        if (Config::get('app.locale') == 'en') {
            return "{$this->main_description_en}";
        } else {
            return "{$this->main_description_ar}";
        }
    }

    public function getSubDescriptionAttribute()
    {
        if (Config::get('app.locale') == 'en') {
            return "{$this->sub_description_en}";
        } else {
            return "{$this->sub_description_ar}";
        }
    }
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
}
