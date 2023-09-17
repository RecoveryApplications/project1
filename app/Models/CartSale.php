<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartSale extends Model
{
    use HasFactory;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'cart_sales';
    protected $guarded = [];


    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================
    // Relation With Customer Model
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    // Relation With CartOperation Model
    public function cartOperations()
    {
        return $this->hasMany(CartOperation::class,'cart_sale_id');
    }

    // Relation With CartOperation Model
    public function payment()
    {
        return $this->hasOne(Payment::class,'invoice_id');
    }

    // Relation With PromoCode Model :
    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id')->withTrashed();
    }

    //  Relation with customer Locations
    public function location(){
        return $this->belongsTo(UserLocation::class, 'location_id');
    }

    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================
    public function getStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Pendding';
        } elseif ($value == 2) {
            return 'Accepted';
        } elseif ($value == 3) {
            return 'Rejected';
        }
    }
    public function getPaymentStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Pendding';
        } elseif ($value == 2) {
            return 'Accepted';
        } elseif ($value == 3) {
            return 'Rejected';
        }
    }
    public function getDeliveryStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Pendding';
        } elseif ($value == 2) {
            return 'In Progress';
        } elseif ($value == 3) {
            return 'Received';
        }
    }
}
