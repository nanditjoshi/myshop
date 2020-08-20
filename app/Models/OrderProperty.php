<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProperty extends Model
{
    protected $fillable = [
        'orders_id',
        'propertycode', 
    ];
}
