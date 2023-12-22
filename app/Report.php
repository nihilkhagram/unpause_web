<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $table = 'report';

    protected $primaryKey = 'id';

    protected $fillable = [

            'first_name','birth_year','ethnic_origin','country_of_residence','height','weight', 'changes_weight', 'often_excercise', 'excercise_patterns_changes',
            'often_consume_alcohol','smoke','period','last_period_date','hot_flashes', 'occur_hf', 'night_sweats', 'cold_flashes', 'occur_cf','affect_sleep'.
            'is_symptoms1','is_symptoms2','experience_symptoms','spoken_abt_menopausal','cycle_lengths_changed_recently','duration_period_changed','bleeding_been_heavier_period','occur_ns','nhs_or_private_healthcare','whom_did_you_consult','received_diagnosis_healthcare_professional','on_hormone_replacement_therapy','which_form_of_HRT_are_you_on','type_of_HRT_routine_are_you_on','type_of_cyclic_HRT_routine_are_you_on',
            'login_id','Created_by','is_active','drinking','exercise','is_delete','created_at', 'updated_at',



            // ,'have_appointment_healthcare', 'when_appointment', 'healthcare_provider_ratting', 'Menopause_help_ratting', 'medications_and_therapies_prescribed','lifestyle_modification'.
            // 'troublesome_symptoms','date_and_day'

    ];

    public $timestamps = false;
}
