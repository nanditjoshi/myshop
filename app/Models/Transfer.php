<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'airport',
        'destination',
        'taxi_type',
        'no_of_passenger',
        'taxi_price',
        'commission',
        'final_price'
    ];
}
