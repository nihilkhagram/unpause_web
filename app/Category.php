<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'category';

    protected $primaryKey = 'id';

    protected $fillable = [

        'category_name','category_image','category_short_info','Created_by','is_active', 'is_delete', 'Created_by', 'Created_dt', 'Modified_dt',

    ];

    public $timestamps = false;
}
