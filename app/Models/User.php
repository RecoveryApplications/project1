<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users';
    protected $fillable = [
        'name_en',
        'username',
        'email',
        'phone',
        'password',
        'profile_photo_path',
        'user_status',
        'created_by',
    ];

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
}
