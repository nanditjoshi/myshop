<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPassengers extends Model
{
    protected $fillable = [
        'orders_id',
        'type', // adults or children
        'is_lead',
        'title',
        'firstname',
        'surname',
        'post_code',
        'house_name',
        'address1',
        'address2',
        'city',
        'country',
        'post_code_add',
        'telephone_no',
             
    ];
}
