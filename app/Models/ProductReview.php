<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'product_reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_type',
        'product_id',
        'review_value',
        'review_note',
    ];

    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    // Relation With Individual Table
    // Created By : Layth Al-Dwairy (L.A.L)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    // Relation With Job Table
    // Created By : Layth Al-Dwairy (L.A.L)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
