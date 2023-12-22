<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BleAddress extends Model
{
	protected $table = 'ble_address';

    protected $primaryKey = 'id';

   protected $fillable = ['user_id','id','ble_address'];
}
