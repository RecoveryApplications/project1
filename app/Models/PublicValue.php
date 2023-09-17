<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicValue extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'public_values';
    protected $guarded = [];
}
