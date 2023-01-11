<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    // protected $table = 'stocks';
    use HasFactory;

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
