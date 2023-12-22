<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';

    protected $fillable = ['title','subtitle','image','created_by','is_active','is_delete','created_at','updated_at'];

}
