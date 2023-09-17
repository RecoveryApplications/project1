<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainSize extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'main_sizes';
    protected $fillable = [
        'name_en',
        'updated_by'
    ];

    protected $date = ['deleted_at'];

    // relation with users table
    // by : Mohammed Salah
    public function user(){
        return $this->belongsTo(User::class,'updated_by');
    }

}
