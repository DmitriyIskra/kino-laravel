<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmSessions extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_film_id',
        'time_from',
    ];
}
