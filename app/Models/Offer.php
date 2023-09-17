<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $table = 'offers';

    protected $guarded = [];

    // protected $fillable = [
    //     'expire_date',
    //     'title_en',
    //     'title_ar',
    //     'amount',
    //     'status'
    // ];


    public function products(){
        return $this->hasMany(Product::class,'offer_id');
    }
}
