<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermAndCondition extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "term_and_conditions";
    protected $fillable = [
        'user_id',
        'user_type',
        'term_and_condition_title_en',
        'term_and_condition_des_en',
        'term_and_condition_status',
    ];
    protected $date = ['deleted_at'];


    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================

    public function getTermAndConditionStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Active';
        } elseif ($value == 2) {
            return 'Not Active';
        }
    }
}
