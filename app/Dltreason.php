<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dltreason extends Model
{
	protected $table = 'dlt_reason';

    protected $primaryKey = 'id';

   // protected $casts = ['is_appointment_done' => 'boolean'];
    

    protected $fillable = [

            'msg','login_id','Created_by','is_active','is_delete','created_at', 'updated_at',

    ];

    public $timestamps = false;
}
