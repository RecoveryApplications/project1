<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = "reviews";

    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['user_id','product_id','rate','comment','status'];

    public function customer(){
        return $this->belongsTo(Customer::class,'user_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
