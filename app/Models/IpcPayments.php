<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpcPayments extends Model
{
    protected $fillable = [
        'ipcmethod',
        'amount',
        'currency',
        'orders_id',
        'ipc_trnref',
        'requeststan',
        'requestdatetime',
        'customerphone',
        'cardtoken',
    ];
}
