<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = ['name','user_id','stock']; //保存したいカラム名が1つの場合
    use HasFactory;

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
