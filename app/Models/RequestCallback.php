<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCallback extends Model
{
    protected $fillable = [
        'requestname',
        'requesttelephone',
        'requestemail',
        'requestcomments'];
}
