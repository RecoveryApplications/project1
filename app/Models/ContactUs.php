<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class ContactUs extends Model
{
    use HasFactory;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'contact_us';
    protected $fillable = [
        'email',
        'phone',
        'address_ar',
        'address_en',
    ];

    public function getAddressAttribute()
    {
        if (Config::get('app.locale') == 'en'){
            return "{$this->address_en}";
        }
        else{
            return "{$this->address_ar}";
        }
    }
}
