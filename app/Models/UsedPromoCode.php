<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedPromoCode extends Model
{
    use HasFactory;
    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'used_promo_codes';
    protected $fillable = [
        'customer_id',
        'promo_code_id',
        'status',
    ];


    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================
    // Relation With Customer Model
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relation With PromoCode Model :
    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id')->withTrashed();
    }

    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================
    public function getStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Used';
        } elseif ($value == 2) {
            return 'Unused';
        }
    }
}
