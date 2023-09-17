<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivacyPolicy extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "privacy_policies";
    protected $fillable = [
        'user_id',
        'user_type',
        'privacy_policy_title_en',
        'privacy_policy_des_en',
        'privacy_policy_status',
    ];
    protected $date = ['deleted_at'];


    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================

    public function getPrivacyPolicyStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Active';
        } elseif ($value == 2) {
            return 'Not Active';
        }
    }
}
