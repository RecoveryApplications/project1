<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class PaymentWallet extends Model
{
    use HasFactory;
    protected $guarded = [];


        // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================
    public function getNameAttribute()
    {
        if (Config::get('app.locale') == 'en') {
            return "{$this->name_en}";
        } else {
            return "{$this->name_ar}";
        }
    }

}
