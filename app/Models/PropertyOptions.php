<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyOptions extends Model
{
    protected $fillable = [
        'propertycode',
        'name',
        'price',
        'pricetype',
        'maxQty',
        'allowedDates',
        'defaultQty',
        'img',
        'optionPayment',
        'description',
    ];    
}
