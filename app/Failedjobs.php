<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Failedjobs extends Model
{
	protected $table = 'failed_jobs';

    protected $primaryKey = 'id';
	
	protected $guarded = [];

    public $timestamps = false;
}

