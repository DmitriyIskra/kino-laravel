<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'number',
        'row',
        'place',
        'price_standart',
        'price_vip',
        'sessions',
    ];

    public function place()
    {
        return $this->hasMany(Place::class);
    }
}
