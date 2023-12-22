<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	protected $table = 'users';   

protected $primaryKey = 'id';

    protected $fillable = [

        'first_name','last_name','phone_number','is_report_generated','token','email','email_verified_at','fcm_token','password','remember_token','google_id','role','otp','is_verified','Is_active','Is_delete','created_at', 'updated_at'	
		];
}
