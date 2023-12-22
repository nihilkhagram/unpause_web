<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usersymptom extends Model
{
	protected $table = 'usersymptom';

    protected $primaryKey = 'id';

    protected $casts = ['is_selected' => 'boolean','none' => 'boolean'];

    
    
    protected $fillable = [

      'symptom_id','title','key_name','is_selected','none','progress','source','source_color','color_code','ddate','login_id','is_active', 'is_delete', 'Created_by', 'Created_dt',

    ];
    

    public $timestamps = false;
}
