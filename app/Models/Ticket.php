<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr',
        'sess_id', 
        'title',
        'places',
        'hall',
        'start',
        'price',
    ];
}
