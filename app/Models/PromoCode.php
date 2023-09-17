<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory;
    use SoftDeletes;
    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'promo_codes';
    protected $fillable = [
        'promo_code',
        'promo_type',
        'promo_value',
        'expiration_date',
        'status',
        'created_by',
    ];


    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

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

    public function getPromoTypeAttribute($value)
    {
        if ($value == 1) {
            return 'Percentage';
        }
    }
}
