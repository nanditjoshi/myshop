<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyUpdate extends Model
{
    protected $fillable = [
        'propertycode',
        'enabled',
        'lastupdate',
        'photolastupdate',
        'specialoffers',
    ];
}
