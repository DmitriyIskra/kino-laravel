<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'poster',
        'title',
        'description',
        'duration',
        'country',
        'is_hall_id',
    ];
}
