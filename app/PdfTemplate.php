<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdfTemplate extends Model
{
	protected $table = 'tbl_pdf_template';

    protected $primaryKey = 'id';

    protected $fillable = [

        'id','name','content'
    ];

    public $timestamps = false;
}
