<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartTemp extends Model
{
    use HasFactory;
    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'cart_temps';
    protected $guarded = [];


    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================
    // Relation With Customer Model
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relation With Product Model
    public function product()
    {
        if($this->property_type == 1){
            return $this->belongsTo(ProdSzeClrRelation::class,'product_id')->withTrashed();
        }else{
            return $this->belongsTo(Product::class,'product_id')->withTrashed();
        }
    }

}
