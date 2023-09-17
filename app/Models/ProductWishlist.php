<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWishlist extends Model
{
    use HasFactory;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'product_wishlists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'customer_id',
    ];

    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    // Relation With Customer Table
    // Created By : Layth Al-Dwairy (L.A.L)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relation With Product Table
    // Created By : Layth Al-Dwairy (L.A.L)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }
}
