<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $table = 'post';

    protected $primaryKey = 'id';

    protected $fillable = [

        'category_id','title','short_desc','long_desc','videos','youtube_url','approve_status','reward_points','Created_by','is_active', 'is_delete', 'created_date', 

    ];

    public $timestamps = false;
}
