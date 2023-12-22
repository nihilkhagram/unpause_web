<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
	protected $table = 'test';

    protected $primaryKey = 'id';

    protected $fillable = [

        'login_id','connected','disconnected','firmware','batteryLevel','temperatureValue','dateAndTimeValue','alertLevel','alertStatus','manufacturerName','modelNumber','serialNumber','temperature','Created_by','is_active', 'is_delete', 'Created_by', 'created_at', 'updated_at',

    ];

    public $timestamps = false;
}
