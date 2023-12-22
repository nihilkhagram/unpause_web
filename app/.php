<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lifttype extends Model
{
	protected $table = 'tbl_lift_type';

    protected $primaryKey = 'id';

    protected $fillable = [

        'lifttype_title', 'Lifttype_price', 'Is_active', 'Is_delete', 'Created_by', 'Created_dt', 'Modified_dt'

    ];

    public $timestamps = false;
}
