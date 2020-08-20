<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'classification',
        'communication',
        'property_code',
        'booking_reference',
        'preferred_contact_method',
        'subject',
        'message',
    ];
}
