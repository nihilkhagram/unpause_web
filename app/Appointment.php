<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
	protected $table = 'appointment';

    protected $primaryKey = 'id';

    protected $casts = ['is_appointment_done' => 'boolean'];
    

    protected $fillable = [

            'date','time','login_id','Created_by','is_active','is_appointment_done','is_delete','created_at', 'updated_at',

    ];

    public $timestamps = false;
}
