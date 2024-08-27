<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'poster',
        'title',
        'description',
        'duration',
        'country',
        'halls_id',
    ];
}
