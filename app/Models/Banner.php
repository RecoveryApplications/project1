<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    use HasFactory;


    protected $table = 'banners';
    protected $guarded = [];


    // =====================================================================================================
    // ============================================= Accessors Section =====================================
    // =====================================================================================================




}
