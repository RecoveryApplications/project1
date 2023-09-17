<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateUsa extends Model
{
    use HasFactory;
    protected $table = "state_usa";
    protected $fillable = [
        'state_ar',
        'state_en',

    ];
}
