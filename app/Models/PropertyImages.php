<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImages extends Model
{
    protected $fillable = [
        'propertycode',
        'main',
        'thumb',
        'tiny',
    ];
}
