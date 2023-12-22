<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
	protected $table = 's_order_items';

    protected $fillable = ['id','user_id','cart_id'];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
