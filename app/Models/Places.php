<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;

    protected $fillable = [
        'hall_id',
        'chair_num',
        'type',
        'is_free',
    ];
}
