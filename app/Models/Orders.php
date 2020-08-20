<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProperty;
use App\Models\OrderPassengers;
use App\Models\IpcPayment;

class Orders extends Model
{
    protected $fillable = [
        'userid',
        'propertycode',
        'adults',
        'children',
        'insurance_id',
        'transfer_id',
        'deposit_pay',
        'remaning_pay',
        'total_price',
        'price_per_persion',
     
    ];

    public function orderPropertys(){
        return $this->hasMany('App\Models\OrderProperty','orders_id','id');
    }

    public function orderPassangers(){
        return $this->hasMany('App\Models\OrderPassengers','orders_id','id');
    }

    public function orderIpcPayment(){
        return $this->hasMany('App\Models\IpcPayment','orders_id','id');
    }

}    
