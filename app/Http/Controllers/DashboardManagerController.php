<?php

namespace App\Http\Controllers;

use App\Users;
use App\Test;
use App\Report;
use App\Symptom;




class DashboardManagerController extends Controller
{
    public function index()
    {
        $users_count = Users::where('is_active',1)->where('is_delete',0)->where('is_verified','!=',0)->count();
        $test_count = Test::where('is_active',1)->where('is_delete',0)->count();
        $report_count = Report::where('is_active',1)->where('is_delete',0)->count();
        $symptom_count = Symptom::where('is_active',1)->where('is_delete',0)->count();
        
      
		 
	
	
	
        $dashboard_count = array(
            'users_count' => $users_count,
            'test_count' => $test_count,
            'report_count' => $report_count,
             'symptom_count' => $symptom_count,
        );

        // dd($product_count);

        return view('dashboard',compact('dashboard_count'));
    }
}
