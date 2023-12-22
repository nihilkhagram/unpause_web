<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
	protected $table = 'symptom';

    protected $primaryKey = 'id';

    protected $casts = ['is_selected' => 'boolean'];

   
    protected $fillable = [

       'symptom_id', 'title','key_name','is_selected','source','source_color','color_code','login_id','is_active', 'is_delete', 'Created_by', 'Created_dt',

    ];

    public $timestamps = false;
}
