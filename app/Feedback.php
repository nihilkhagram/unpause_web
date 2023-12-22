<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	protected $table = 'feedback';

    protected $primaryKey = 'id';

   

   
    protected $fillable = [

       'healthcare_provider_hear_you_thoroughly', 'menopause_checklist_help','medications_and_therapies_have_been_prescribed','ask_to_introduce_any_lifestyle_modification','is_selected','source','source_color','color_code','login_id','is_active', 'is_delete', 'Created_by', 'Created_dt',

    ];

    public $timestamps = false;
}
