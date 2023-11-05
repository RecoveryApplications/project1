<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'customers';
    protected $fillable = [
        'name_en',
        'username',
        'company_name',
        'email',
        'phone',
        'password',
        'country_key',
        'country_id',
        'profile_photo_path',
        'user_status',
        'created_by',
    ];

    protected $date = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    public function locations()
    {
        return $this->hasMany(UserLocation::class, 'user_id');
    }

    public function cartTemps()
    {
        return $this->hasMany(CartTemp::class, 'user_id')->with('product');
    }

    public function wishlist()
    {
        return $this->hasMany(ProductWishlist::class, 'customer_id');
    }

    public function cartSales()
    {
        return $this->hasMany(CartSale::class, 'user_id')->with('cartOperations');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'customer_id')->orderBy('amount_withdrawn', 'asc');
    }

    public function paymentWalletOrders()
    {
        return $this->hasMany(PaymentWalletOrder::class, 'customer_id');
    }
    public function paidPaymentWalletOrders()
    {
        return $this->hasMany(PaymentWalletOrder::class, 'customer_id')->where('status', 'paid');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


    // ===================================================================================================================
    // ============================================= Mutator Section =====================================================
    // ===================================================================================================================




    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================

    public function getUserStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Pendding';
        } elseif ($value == 2) {
            return 'Active';
        } elseif ($value == 3) {
            return 'Inactive';
        }
    }


    public function getTotalPaidOrderWalletsAttribute($value)
    {
        $sum = 0;
        foreach ($this->paymentWalletOrders as $key => $paymentWalletOrder) {
            $sum += $paymentWalletOrder->amount;
        }
        return $sum;
    }
}
