<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $table = 'notification';

    protected $primaryKey = 'id';

   // protected $casts = ['is_appointment_done' => 'boolean'];
    

    protected $fillable = [

            'msg','login_id','Created_by','is_active','is_delete','created_at', 'updated_at',

    ];
    public function getNotificationAttribute()
    {
        return json_decode($this->msg);
    }

    public $timestamps = false;
}
