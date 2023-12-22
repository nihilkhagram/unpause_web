<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitesetting;
class SitesettingController extends Controller
{
    //
	public function index()
	{
		$sitesetting = Sitesetting::where('id',1)->get();
		return view('sitesetting.index',['sitesetting'=>$sitesetting]);
	}
	public function update(Request $request,$id)
	{
		try
		{
			$this->validate($request,[
							'company_name'=>'required',
							'address'=>'required',
							'pan_no'=>'required',
							'cin_no'=>'required',
							'telephone_no'=>'required',
							'website'=>'required']);
			$data['company_name'] = $request->get('company_name');
			$data['address'] = $request->get('address');
			$data['pan_no'] = $request->get('pan_no');
			$data['cin_no'] = $request->get('cin_no');
			$data['telephone_no'] = $request->get('telephone_no');
			$data['website'] = $request->get('website');
			Sitesetting::where('id',$id)->update($data);
			return redirect('/site_setting')->with('flash_message_success','Data updated successfully.');
				
		
		}catch (\Illuminate\Validation\ValidationException $e )
		{
		
			$arrError = $e->errors(); 
			
			return redirect()->back()->withErrors($arrError);
		}
		catch (\Exception $e) {
          
			return redirect()->back()->with('flash_message_error',$e->getMessage());
		}
	}
}
