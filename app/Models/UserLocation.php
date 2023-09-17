<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLocation extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    protected $table = 'user_locations';
    protected $fillable =[
    'user_id',
    'email',
    'phone',
    'name',
    'company',
    'address',
    'apartment',
    'city',
    'state',
    'zipcode',
    'country',
    'more_info',
    ];




    public function customer(){
        return $this->belongsTo(Customer::class,'user_id');
    }

}
