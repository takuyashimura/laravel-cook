<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
