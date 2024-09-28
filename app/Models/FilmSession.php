<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id',
        'film_name',
        'hall_id',
        'start_h',
        'start_m',
        'duration',
    ];
}
