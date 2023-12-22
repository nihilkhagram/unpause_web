<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menopause extends Model
{
	protected $table = 'menopause';

    protected $primaryKey = 'id';

    protected $fillable = [

            'first_name','age','weight','smoking','drinking','exercise', 'pdf_generated_date', 'hot_flashes', 'night_sweats',
            'cold_flashes','physchological','physical','last_period','cycle_changed', 'heavier_bleeding', 'my_management', 'hrt_routine','login_id','Created_by','is_active', 'is_delete','created_at', 'updated_at',

    ];

    public $timestamps = false;
}
