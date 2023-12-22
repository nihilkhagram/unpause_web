<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
        //return view('dashboard');
    }
    public function otas()
    {
        $ota = \DB::table('ota_files')->get()->first();
        return view('otas.form',compact('ota'));
    }
    public function otas_post(Request $request)
    {
        
        $this->validate($request,[
            'stm_file' =>'required|file',
            'ota_file' =>'required|file',
        ]);
        $url =  \URL::to('/');
        $sfileNameToStore = '';
        if($request->hasFile('stm_file')){
            $filenameWithExt=$request->file('stm_file')->getClientOriginalName();
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension=$request->file('stm_file')->getClientOriginalExtension();
            $sfileNameToStore=$filename.'_'.time().'.'.$extension;
            request()->stm_file->move(public_path('ota_files/'), $sfileNameToStore);
            $array['stm_file'] = $url.'/ota_files/'.$sfileNameToStore; 
            \DB::table('ota_files')->where('id',1)->update($array);
        }
        $ofileNameToStore = '';
        if($request->hasFile('ota_file')){
            $filenameWithExt=$request->file('ota_file')->getClientOriginalName();
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension=$request->file('ota_file')->getClientOriginalExtension();
            $ofileNameToStore=$filename.'_'.time().'.'.$extension;
            request()->ota_file->move(public_path('ota_files/'), $ofileNameToStore);
            $array['ota_file'] = $url.'/ota_files/'.$ofileNameToStore; 
            \DB::table('ota_files')->where('id',1)->update($array);
        }
        
        
        
        

        

        return redirect()->back()->with('success','File Updated Successfully');
    }
  

}
