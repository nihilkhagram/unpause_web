<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'tbl_role';
protected $primaryKey = 'id';

    protected $fillable = [

        'role_name','created_at', 'updated_at'	
		];    
}
