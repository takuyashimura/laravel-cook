<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodMenu extends Model
{
    use HasFactory;
    protected $fillable = ['food_amount','food_id','menu_id']; //保存したいカラム名が複数の場合
    public $timestamps = false;


}
