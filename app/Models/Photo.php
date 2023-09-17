<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;

    protected $table = "photos";
 
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['name_img'];



}
