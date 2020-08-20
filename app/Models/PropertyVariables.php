<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyVariables extends Model
{
    protected $fillable = [
        'propertycode',
        'varcatname',
        'varcatcombined',
    ];    
}
