<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdSzeClrRelation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "prod_sze_clr_relations";
    protected $fillable = [
        'main_size_id',
        'main_color_id',
        'product_id',
        'status',
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
    ];

    protected $date = ['deleted_at'];



    // relation with Main Color table
    // by : Mohammed Salah
    public function color(){
        return $this->belongsTo(MainColor::class,'main_color_id');
    }

    // relation with Main Size table
    // by : Mohammed Salah
    public function size(){
        return $this->belongsTo(MainSize::class,'main_size_id');
    }


    // relation with Main Size table
    // by : Mohammed Salah
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }


    // Relation With propertyImages Model :
    public function propertyImages()
    {
        return $this->hasMany(PropertyImage::class,'property_id');
    }


    // Relation With CartOperation Model :
    public function cartOperations()
    {
        return $this->hasMany(CartOperation::class, 'product_id')->where('property_type',1);
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


    public function getActiveColorsAttribute($value)
    {
        return ProdSzeClrRelation::where('product_id',$this->product_id)->where('main_size_id',$this->main_size_id)->get()->pluck('main_color_id')->toArray();
    }

    public function getActiveSizesAttribute($value)
    {
        return ProdSzeClrRelation::where('product_id',$this->product_id)->where('main_color_id',$this->main_color_id)->get()->pluck('main_size_id')->toArray();
    }


}

