<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sideringsize extends Model
{
    //
    protected $table = 'side_ring_size';

    protected $primaryKey = 'id';

    protected $fillable = [

        'side_ring_size','Is_active','Is_delete','Created_by','Created_dt','Modified_dt',

    ];

    public $timestamps = false;

}
