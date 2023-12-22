<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use App\Category;
use App\Test;
use App\Post;
use App\Report;
use App\Symptom;
use App\Menopause;
use App\Appointment;
use App\Usersymptom;

use App\Dltreason;
use App\Feedback;
use Carbon\Carbon;
use App\Notification;
use App\BleAddress;
use \PDF;


use Log;

use Illuminate\Support\Facades\Mail;
use App\Mail\sendEmail;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Str;

class ApiController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        // print_r('d');
        // exit;

        if($request->google_id)
        {

                $v2=1;
                $have_gid=User::where('google_id',$request->google_id)->where('email','=',$request->gmail_id)->where('is_verified',$v2)->first();
                if($have_gid)
                {

                    if($have_gid->is_report_generated==1)
                    {
                        $have_gid->is_report_generated='true';
                        $find=Report::where('login_id','=',$have_gid->id)->first();
                        $name ='Report_'. $find->login_id . '.pdf';
                        $url = \URL::to('/') . '/report/' . $name;
                        $have_gid->report=$url;
                    }
                    else
                    {
                        $have_gid->is_report_generated='false';

                    }
                    $token = $have_gid->createToken('token')->accessToken;
                    $have_gid->token = $token;
                    $fcm_token = $request->fcm_token;
                        if($fcm_token)
                        {
                            $have_gid->fcm_token =  $fcm_token;
                            $have_gid->save();
                        }

                    $success['result'] = true;
                    $success['message'] = "Register Successfully";
                    $success['data'] = $have_gid;
                    return $this->sendResponse($success);




                }
                else
                {
                    $input = new User();
                    $input->google_id = $request->google_id;
                    $input->email = $request->gmail_id;
                    $input->fcm_token = $request->fcm_token;
                    $input->is_verified=1;
                    $input->save();

                    $symptoms=Symptom::get();


                    foreach($symptoms as $k => $symptom)
                    {
                        $usersymptom = new Usersymptom();

                        $usersymptom->symptom_id = $symptom->symptom_id;
                        $usersymptom->title = $symptom->title;
                        $usersymptom->key_name = $symptom->key_name;
                        $usersymptom->is_selected = 0;
                        $usersymptom->source = $symptom->source;
                        $usersymptom->source_color = $symptom->source_color;
                        $usersymptom->color_code = $symptom->color_code;
                        $usersymptom->login_id = $input->id;
                        $usersymptom->Created_by = $input->id;
                        $today=Carbon::now()->format('Y-m-d');
                        $usersymptom->ddate = $today;

                        $usersymptom->save();

                    }









                    $user_id=$input->id;
                     $report=User::where('id','=',$user_id)->first();
                    if($report)
                    {
                        $report->is_report_generated='true';
                       // $find=Report::where('login_id','=',$have_gid->id)->first();
                        $name ='Report_'. $report->login_id . '.pdf';
                        $url = \URL::to('/') . '/report/' . $name;
                        $report->report='';//$url;
                    }
                    else
                    {
                        $report->is_report_generated='false';
                    }

                    $token = $report->createToken('token')->accessToken;
                    $report->token = $token;
                    $success['result'] = true;
                    $success['data'] =  $report;
                   // $success['remember_token'] =  $token;
                    $success['message'] = "User Register SuccessFully!";
                    return $this->sendResponse($success);


                }
        }
        else
        {

                $validator = Validator::make($request->all(), [
                //  'first_name' => 'required',
                    //'email' => 'required|unique:users',
                    'email' => 'required',
                    'password' => 'required',
                    'fcm_token'=> 'required',
                    're_password' => 'required|same:password',
                ]);

                if($validator->fails()){
                    $success['result'] = "false";
                    $success['message'] = $validator->errors()->first();
                    return $this->sendResponse($success);
                }

                $user=User::where('email','=',$request->email)->first();

                if($user)
                {
                    $v1=0;
                    $verify=User::where('email','=',$request->email)->where('is_verified',$v1)->first();
                    $v2=1;
                    $already_verified=User::where('email','=',$request->email)->where('is_verified',$v2)->first();
                        if($verify)
                        {
                            $is_verified=1;
                            $is_verify = User::where('email','=',$request->email)->where('is_verified',$v1)->update(['is_verified' => $is_verified]);
                            $is_report_generated= $is_verify->is_report_generated;
                            // if($is_verify->is_report_generated==1)
                            // {
                            //     $is_report_generated=$is_verify->is_report_generated='true';
                            // }
                            // else
                            // {
                            //     $is_report_generated=$is_verify->is_report_generated='false';

                            // }
                           
                             
                            $success['result'] = true;
                            $success['is_report_generated'] = $is_report_generated;
                            $success['message'] = "User SuccessFully Verified!";
                            return $this->sendResponse($success);
                        }
                        else if($already_verified)
                        {
                            if($already_verified->is_report_generated==1)
                            {
                                $is_report_generated=$already_verified->is_report_generated='true';
                                $name ='Report_'. $already_verified->login_id . '.pdf';
                                $url = \URL::to('/') . '/report/' . $name;
                                $is_report_generated->report=$url;
                            }
                            else
                            {
                                $is_report_generated=$already_verified->is_report_generated='false';

                            }
                            $success['result'] = false;
                            $success['is_report_generated'] = $is_report_generated;
                            $success['message'] = "User Already Register";
                            return $this->sendResponse($success);


                        }
                        else
                        {

                        }



                }
                else
                {

                    $input = new User();
                    $input->email = $request->email;
                    $input->fcm_token = $request->fcm_token;
                    $input->password = Hash::make($request->password);
                    $input->re_password = Hash::make($request->re_password);
                    $input->save();

                    $symptoms=Symptom::get();


                    foreach($symptoms as $k => $symptom)
                    {
                        $usersymptom = new Usersymptom();

                        $usersymptom->symptom_id = $symptom->symptom_id;
                        $usersymptom->title = $symptom->title;
                        $usersymptom->key_name = $symptom->key_name;
                        $usersymptom->is_selected = 0;
                        $usersymptom->source = $symptom->source;
                        $usersymptom->source_color = $symptom->source_color;
                        $usersymptom->color_code = $symptom->color_code;
                        $usersymptom->login_id = $input->id;
                        $usersymptom->Created_by = $input->id;
                        $today=Carbon::now()->format('Y-m-d');
                        $usersymptom->ddate = $today;
                        $usersymptom->save();

                    }


                    $token = $input->createToken('token')->accessToken;
                    $input->token = $token;
                    if($input->is_report_generated==1)
                    {
                        $input->is_report_generated='true';

                        $name ='Report_'. $input->login_id . '.pdf';
                        $url = \URL::to('/') . '/report/' . $name;
                        $report->report=$url;
                    }
                    else
                    {
                        $input->is_report_generated='false';

                    }

                        if($input)
                        {

                        //

                            $success['result'] = true;
                            $success['data'] =  $input;
                           // $success['remember_token'] =  $input->remember_token;
                            $success['message'] = "User Register SuccessFully!";
                            return $this->sendResponse($success);
                        }
                        else
                        {
                            $success['result'] = false;
                            $success['message'] = "Something Went Wrong!";
                            return $this->sendResponse($success);
                        }
                }
        }


    }

    public function login(Request $request)
    {

        if($request->google_id)
        {

            $is_verified=1;
            $google_user  = User::where([['google_id','=',$request->google_id],['email','=',$request->gmail_id],['is_verified','=',$is_verified]])->first();
            if($google_user)
            {

                if($google_user->is_report_generated==1)
                {
                    $google_user->is_report_generated='true';
                    $find=Report::where('login_id','=',$google_user->id)->first();
                        $name ='Report_'. $find->login_id . '.pdf';
                        $url = \URL::to('/') . '/report/' . $name;
                        $google_user->report=$url;
                }
                else
                {
                    $google_user->is_report_generated='false';

                }
                

                $token = $google_user->createToken('token')->accessToken;
                $google_user->token = $token;

                $success['result'] = true;
               // $success['token'] = $token; //$google_user->createToken('token')->accessToken;
                $success['message'] = "Login Successfully";
                $success['data'] = $google_user;
                return $this->sendResponse($success);

            }
            else
            {

                $input = new User();
                $input->google_id = $request->google_id;
                $input->fcm_token = $request->fcm_token;
                $input->email = $request->gmail_id;
                $input->is_verified = 1;
                $input->save();


                $symptoms=Symptom::get();


                    foreach($symptoms as $k => $symptom)
                    {
                        $usersymptom = new Usersymptom();

                        $usersymptom->symptom_id = $symptom->symptom_id;
                        $usersymptom->title = $symptom->title;
                        $usersymptom->key_name = $symptom->key_name;
                        $usersymptom->is_selected = 0;
                        $usersymptom->source = $symptom->source;
                        $usersymptom->source_color = $symptom->source_color;
                        $usersymptom->color_code = $symptom->color_code;
                        $usersymptom->login_id = $input->id;
                        $usersymptom->Created_by = $input->id;
                        $today=Carbon::now()->format('Y-m-d');
                        $usersymptom->ddate = $today;
                        $usersymptom->save();

                    }

                if($input->is_report_generated==1)
                {
                    $input->is_report_generated='true';
                    $find=Report::where('login_id','=',$input->id)->first();
                        $name ='Report_'. $find->login_id . '.pdf';
                        $url = \URL::to('/') . '/report/' . $name;
                        $input->report=$url;

                }
                else
                {
                    $input->is_report_generated='false';

                }

                    if($input)
                    {
                        $user_id = $input->id;
                        $user = User::where('id',$user_id)->first();
                        $fcm_token = $request->fcm_token;
                        if($fcm_token)
                        {
                            $user->fcm_token =  $fcm_token;
                            $user->save();
                        }
                        $token = $input->createToken('token')->accessToken;
                        $user->token = $token;

                        $success['result'] = true;
                        $success['message'] = "Login Successfully";
                        $success['data'] = $user;
                        return $this->sendResponse($success);
                    }
                    else
                    {
                        $success['result'] = false;
                        $success['message'] = "Something Went Wrong!";
                        return $this->sendResponse($success);
                    }


            }

        }
        else
        {

                $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email',
                    'password' => 'required'
                ]);
                //$headers = apache_request_headers();
                if($validator->fails()){
                    return $this->sendError($validator->errors());
                }



                $credentials = request(['email', 'password']);
                if(!Auth::attempt($credentials)){

                    // $error = "Unauthorized";
                    // return $this->sendError($error, 401);
                    $success['result'] = false;
                    $success['message'] = "Your Username Or Password Is Wrong";
                    return $this->sendResponse($success);


                }
                $user = $request->user();
                if($user->is_verified==1 || $user->is_verified==2){

                    if($user->is_report_generated==1)
                    {
                        $user->is_report_generated='true';
                        $find=Report::where('login_id','=',$user->id)->first();
                        $name ='Report_'. $find->login_id . '.pdf';
                        $url = \URL::to('/') . '/report/' . $name;
                        $user->report=$url;
                    }
                    else
                    {
                        $user->is_report_generated='false';

                    }

                    $token = $user->createToken('token')->accessToken;
                    $user->token = $token;
                    $fcm_token = $request->fcm_token;
                        if($fcm_token)
                        {
                            $user->fcm_token =  $fcm_token;
                            $user->save();
                        }

                        $success['result'] = true;
                       // $success['token'] = $token; //$user->remember_token;//$user->createToken('token')->accessToken;
                        $success['message'] = "Login Successfully";
                        $success['data'] = $user;
                        return $this->sendResponse($success);


                }
                else
                {
                    $success['result'] = false;
                    $success['message'] = "User Not Verified";
                    return $this->sendResponse($success);

                }
        }


    }

    public function request_otp(Request $request)
    {

    // print_r('d');
    // exit;

        // $otp = rand(1000,9999);
        // Log::info("otp = ".$otp);
       $otp=1234;

            $email=$request->email;
            // print_r($email);
            // exit;

        $mail_details = [
            'subject' => 'Testing Application OTP',
            'body' => 'Your OTP is : '. $otp
        ];



        $mail_response =  \Mail::to($request->email)->send(new sendEmail($mail_details));

        // dd($mail_response);

        $user = User::where('email','=',$request->email)->update(['otp' => $otp]);
        if (Mail::failures()) {
            //return response(["status" => 401, 'message' => 'Invalid']);

            $success['result'] = false;
            $success['message'] = "OTP sent Unsuccessfully";
            return $this->sendResponse($success);
        }
        else{
             $success['result'] = true;
                $success['message'] = "OTP sent successfully";
                return $this->sendResponse($success);

       //  return response(["status" => 200, "message" => "OTP sent successfully"]);
        }



    }
    public function verify_otp(Request $request)
    {

        $user  = User::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
         if($user){
         //  auth()->login($user, true);
           // User::where('email','=',$request->email)->update(['otp' => null]);
           // $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $is_verified=1;
            $is_verify = User::where('email','=',$request->email)->update(['is_verified' => $is_verified]);



           // return response(["status" => 200, "message" => "Success"]);
           $success['result'] = true;
           $success['message'] = "OTP Verified successfully";
           return $this->sendResponse($success);
        }
        else{
           // return response(["status" => 401, 'message' => 'Invalid']);
           $success['result'] = false;
           $success['message'] = "Please enter valid OTP";
           return $this->sendResponse($success);

        }
    }

    public function get_appointment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
        ]);

        $input = new Appointment();
        $input->date = date('Y-m-d', strtotime($request->date));
        $input->time = $request->time;
        $input->login_id = auth()->id();
        $input->Created_by = auth()->id();
        $login_id = auth()->id();
        $already_added = Appointment::where('login_id',$login_id)->first();
        if($already_added)
        {

                    $today=Carbon::now()->format('Y-m-d H:i');
                    $add_d= date('Y-m-d', strtotime($request->date)) ;
                    $add_t= date("H:i", strtotime($request->time));
                    $dt=date('Y-m-d H:i', strtotime("$add_d $add_t"));



                    // if($dt < $today)
                    // {
                    //     $success['result'] = false;
                    //     $success['message'] = "Already Added Appointment And Also Appoinment gone";
                    //     return $this->sendResponse($success);
                    // }
                    // else if($dt > $today)
                    // {
                    //     $success['result'] = false;
                    //     $success['message'] = "Already Added Appointment And Appoinment Is On The Way ";
                    //     return $this->sendResponse($success);

                    // }
                    // else
                    // {

                    // }
                    $already_added->date=$add_d;
                    $already_added->time=$add_t;
                    $already_added->save();
                    $already_added->date=date('d-m-Y', strtotime($already_added->date));
                    $success['result'] = true;
                    $success['data'] =  $already_added;
                    $success['message'] = "Your Appoinment Change Successfully";
                    return $this->sendResponse($success);



        }
        else
        {

            $apointment_list = Appointment::select(DB::raw("CONCAT(date,' ',time) as fdt"))->where('login_id',$login_id)->get()->pluck('fdt');
                    $d=$request->date;
                    $t=$request->time;
                    $req_dt= date('Y-m-d H:i', strtotime("$d $t"));
                    $today=Carbon::now()->format('Y-m-d H:i');
            if(count($apointment_list))
            {
                foreach($apointment_list as $index => $fdt)
                {

                                if($fdt < $req_dt && $fdt == $today )
                                {
                                    $input->save();
                                    $input->date=date('d-m-Y', strtotime($input->date));

                                    $success['result'] = true;
                                    $success['data'] =  $input;
                                    $success['message'] = "Your Appointment Booked SuccessFully";
                                    return $this->sendResponse($success);

                                }
                                else
                                {
                                        $date = date('Y-m-d', strtotime($request->date));
                                        $time = $request->time;
                                        $reqdt= date('Y-m-d H:i', strtotime("$date $time"));
                                        if($today > $reqdt)
                                        {
                                            $is_appointment_done = 1;
                                        }
                                        else
                                        {
                                            $is_appointment_done = 0;
                                        }

                                        Appointment::where('login_id',$login_id)->update(['date' => $date,'time'=>$time,'is_appointment_done'=>$is_appointment_done]);
                                        $success['result'] = false;
                                        $success['message'] = "You Have Already Booked Your Appointment Is On The Way ";
                                        return $this->sendResponse($success);

                                }




                }


            }
            else
            {
                if($today < $req_dt )
                {
                        $input->save();
                        $input->date=date('d-m-Y', strtotime($input->date));
                        $success['result'] = true;
                        $success['data'] =  $input;
                        $success['message'] = "Your Appointment Booked SuccessFully";
                        return $this->sendResponse($success);
                }
                else
                {
                                $success['result'] = false;
                                $success['message'] = "Sorry You Are Trying To Get On This Date Is Gone";
                                return $this->sendResponse($success);

                }

            }

        }

    }



    public function get_appointment_information(Request $request)
    {
        $us=auth()->id();
        $find_appointment = Appointment::where('login_id',$us)->get();


        if(count($find_appointment)>0)
        {
            $find_date = Appointment::where('login_id',$us)->pluck('date')->toArray();
            $find_time = Appointment::where('login_id',$us)->pluck('time')->toArray();
            $finds = Appointment::where('login_id',$us)->first();


            $fd=implode(',',$find_date);
            $ft=implode(',',$find_time);

            $fdt=date('Y-m-d H:i', strtotime("$fd $ft"));

            $finds->datetime = $fdt;
            $today=Carbon::now()->format('Y-m-d H:i');


            if($fdt > $today)
            {
                $is_appointment=0;
                $find= Appointment::where('login_id',$us)->update(['is_appointment_done' => $is_appointment]);
                $finds = Appointment::where('login_id',$us)->first();

                // if($finds->is_appointment_done==0)
                // {
                //     $finds->is_appointment_done='false';
                // }
                $finds->date=date('d-m-Y', strtotime($finds->date));
                $finds->datetime = date('d-m-Y H:i:s', strtotime("$finds->date $finds->time"));
                $success['result'] = true;
                $success['data']=$finds;
                $success['message'] = "Your Booked Appointment Is On The Way ";
                return $this->sendResponse($success);



            }
            else
            {

               $is_appointment=1;
                $find= Appointment::where('login_id',$us)->update(['is_appointment_done' => $is_appointment]);
                $finds = Appointment::where('login_id',$us)->first();

                if($finds->is_appointment_done==1)
                    {
                        $finds->is_appointment_done='true';
                    }

                $finds->date=date('d-m-Y', strtotime($finds->date));
                $finds->datetime = date('d-m-Y H:i:s', strtotime("$finds->date $finds->time"));
                $success['result'] = true;
                $success['data']=$finds;
                $success['message'] = "Your Appointment Completed";
                return $this->sendResponse($success);

            }





        }
        else
        {
            $success['result'] = false;
            $success['message'] = "No Appointment";
            return $this->sendResponse($success);

        }




    }


    public function send_otp_for_forgot_password(Request $request)
    {
         // print_r('d');
    // exit;

        // $otp = rand(1000,9999);
        // Log::info("otp = ".$otp);
            $otp=1235;

            $email=$request->email;
            // print_r($email);
            // exit;

        $mail_details = [
            'subject' => 'Testing Application OTP',
            'body' => 'Your OTP is : '. $otp
        ];



        $mail_response =  \Mail::to($request->email)->send(new sendEmail($mail_details));

        // dd($mail_response);

        $user = User::where('email','=',$request->email)->update(['otp' => $otp]);
        if (Mail::failures())
        {
           // return response(["status" => 401, 'message' => 'Invalid']);
           $success['result'] = false;
           $success['message'] = "OTP sent Unsuccessfully For Forget Password";
           return $this->sendResponse($success);

        }
        else
        {
            $success['result'] = true;
            $success['message'] = "OTP sent successfully For Forget Password";
            return $this->sendResponse($success);
           // return response(["status" => 200, "message" => "OTP sent successfully"]);
        }
    }

    public function get_appointment_notification(Request $request)
    {
        $login_id = auth()->id();
        $input = new Notification();
        $input->msg = 'Notification Sent';//$request->msg;
        $input->login_id = auth()->id();
        $input->Created_by = auth()->id();
        $input->save();
        $success['result'] = true;
        $success['message'] = "Your Notification Sent";
        return $this->sendResponse($success);

    }




    public function verify_otp_for_forgot_password(Request $request)
    {
                $user  = User::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
                if($user){
                //  auth()->login($user, true);
                // User::where('email','=',$request->email)->update(['otp' => null]);
                // $accessToken = auth()->user()->createToken('authToken')->accessToken;
                $is_verified=2;
                $is_verify= User::where('email','=',$request->email)->update(['is_verified' => $is_verified]);

                $success['result'] = true;
                $success['message'] = "OTP Verified successfully For Forget Password";
                return $this->sendResponse($success);

                //return response(["status" => 200, "message" => "Success"]);
            }
            else{
                $success['result'] = false;
                $success['message'] = "Please enter valid OTP";
                return $this->sendResponse($success);
                //return response(["status" => 401, 'message' => 'Invalid']);
            }
    }
    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
              'password' => 'required',
              're_password' => 'required|same:password',
          ]);
          $is_verified=2;
        $user  = User::where([['email','=',$request->email],['is_verified','=',$is_verified]])->first();
        // print_r($user);
        // exit;
        if($user)
        {

            //$user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->re_password = Hash::make($request->re_password);
            $user->save();

            $success['result'] = true;
            $success['message'] = "Password Change Successfully";
            return $this->sendResponse($success);

        }
        else{
             $success['result'] = false;
            $success['message'] = "Password Change UnSuccessfully";
            return $this->sendResponse($success);

        }

    }


    public function get_feedback(Request $request)
    {

        $input = new Feedback();
        $input->healthcare_provider_hear_you_thoroughly = $request->healthcare_provider_hear_you_thoroughly;
        $input->menopause_checklist_help = $request->menopause_checklist_help;
        $input->medications_and_therapies_have_been_prescribed = $request->medications_and_therapies_have_been_prescribed;
        $input->ask_to_introduce_any_lifestyle_modification = $request->ask_to_introduce_any_lifestyle_modification;
        $input->login_id = auth()->id();
        $input->Created_by = auth()->id();
        $input->save();
        $success['result'] = true;
            $success['message'] = "Feedback Submit Successfully";
            return $this->sendResponse($success);


    }
    public function add_report(Request $request)
    {

        try {


            $req = $request->all();

            $file = fopen('reports.txt','a+');
            fwrite($file,print_r($request->all(),true));
            fclose($file);

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                // 'birth_year' => 'required',
                // 'ethnic_origin' => 'required',
                // 'country_of_residence' => 'required',
                // 'height' => 'required',
                // 'weight' => 'required',
                // 'changes_weight' => 'required',
                // 'often_excercise' => 'required',
                // 'excercise_patterns_changes' => 'required',
                // 'often_consume_alcohol' => 'required',
                // 'smoke' => 'required',
                // 'period' => 'required',
                // 'last_period_date' => 'required',
                // 'hot_flashes' => 'required',
                // 'occur_hf' => 'required',
                // 'night_sweats' => 'required',
                // 'cold_flashes' => 'required',
                // 'occur_cf' => 'required',
                // 'affect_sleep' => 'required',
                // 'is_symptoms1' => 'required',
                // 'is_symptoms2' => 'required',
                // 'experience_symptoms' => 'required',
                // 'spoken_abt_menopausal' => 'required',
                // 'cycle_lengths_changed_recently' => 'required',
                // 'duration_period_changed' => 'required',
                // 'bleeding_been_heavier_period' => 'required',
                // 'occur_ns' => 'required',
                // 'nhs_or_private_healthcare' => 'required',
                // 'whom_did_you_consult' => 'required',
                // 'received_diagnosis_healthcare_professional' => 'required',
                // 'on_hormone_replacement_therapy' => 'required',
                // 'which_form_of_HRT_are_you_on' => 'required',
                // 'type_of_HRT_routine_are_you_on' => 'required',
                // 'type_of_cyclic_HRT_routine_are_you_on' => 'required',
                // 'drinking' => 'required',
                // 'exercise' => 'required',
                ]);

                if($validator->fails())
                {
                    $add_id = auth()->id();
                    $companies =Report::where('login_id','=',$add_id)->orderby('id','DESC')->first();

                    if(!empty($companies))
                    {
                        //foreach ($companies as $k => $val) {
                            $input = $companies;
                            $pdf = PDF::loadView('report.pdfg', compact('input'));
                            $pdf->setPaper('a4', 'portrait');
                            $name ='Report_'. $companies->login_id . '.pdf';
                            $pdf->save(public_path('report/' . $name));
                            $url = \URL::to('/') . '/report/' . $name;
                        // $input[$k]->pdf_url = $url;
                        //}
                            $pdf_details = ['url' => $url];
                        $success['result'] = true;
                        $success['data'] = (object) $pdf_details;
                        $success['message'] = "Report Generated Pdf Successfully";
                        return $this->sendResponse($success);
                    }   else
                    {
                        $success['result'] = false;
                        $success['message'] = "No Report created!";
                        return $this->sendResponse($success);
                    }
                }
                else
                {

                $input = new Report();
                $input->first_name = $request->first_name;
                $input->birth_year = $request->birth_year;
                $input->ethnic_origin = $request->ethnic_origin;
                $input->country_of_residence = $request->country_of_residence;
                $input->height = $request->height;
                $input->weight = $request->weight;
                $input->changes_weight = $request->changes_weight;
                $input->often_excercise = $request->often_excercise;
                $input->excercise_patterns_changes = $request->excercise_patterns_changes;
                $input->often_consume_alcohol = $request->often_consume_alcohol;
                $input->smoke = $request->smoke;
                $input->period = $request->period;
                $input->last_period_date = $request->last_period_date;
                $input->hot_flashes = $request->hot_flashes;
                $input->occur_hf = $request->occur_hf;
                $input->night_sweats = $request->night_sweats;
                $input->cold_flashes = $request->cold_flashes;
                $input->occur_cf = $request->occur_cf;
                $input->affect_sleep = $request->affect_sleep;
                $input->is_symptoms1 = $request->is_symptoms1;
                $input->is_symptoms2 = $request->is_symptoms2;
                $input->experience_symptoms = $request->experience_symptoms;
                $input->spoken_abt_menopausal = $request->spoken_abt_menopausal;
                $input->cycle_lengths_changed_recently = $request->cycle_lengths_changed_recently;
                $input->duration_period_changed = $request->duration_period_changed;
                $input->bleeding_been_heavier_period = $request->bleeding_been_heavier_period;
                $input->occur_ns = $request->occur_ns;
                $input->nhs_or_private_healthcare = $request->nhs_or_private_healthcare;
                $input->whom_did_you_consult = $request->whom_did_you_consult;
                $input->received_diagnosis_healthcare_professional = $request->received_diagnosis_healthcare_professional;
                $input->on_hormone_replacement_therapy = $request->on_hormone_replacement_therapy;
                $input->which_form_of_HRT_are_you_on = $request->which_form_of_HRT_are_you_on;
                $input->type_of_HRT_routine_are_you_on = $request->type_of_HRT_routine_are_you_on;
                $input->type_of_cyclic_HRT_routine_are_you_on = $request->type_of_cyclic_HRT_routine_are_you_on;
                $input->drinking = $request->drinking;
                $input->exercise = $request->exercise;

                $input->login_id = auth()->id();
                $input->Created_by = auth()->id();
                $add_id= $input->login_id ;


                $added=Report::where('login_id','=',$add_id)->first();

            if($added)
            {

                $added->first_name = $input->first_name;
                $added->birth_year = $input->birth_year;
                $added->ethnic_origin = $input->ethnic_origin;
                $added->country_of_residence = $input->country_of_residence;
                $added->height = $input->height;
                $added->weight = $input->weight;
                $added->changes_weight = $input->changes_weight;
                $added->often_excercise = $input->often_excercise;
                $added->excercise_patterns_changes = $input->excercise_patterns_changes;
                $added->often_consume_alcohol = $input->often_consume_alcohol;
                $added->smoke = $input->smoke;
                $added->period = $input->period;
                $added->last_period_date = $input->last_period_date;
                $added->hot_flashes = $input->hot_flashes;
                $added->occur_hf = $input->occur_hf;
                $added->night_sweats = $input->night_sweats;
                $added->cold_flashes = $input->cold_flashes;
                $added->occur_cf = $input->occur_cf;
                $added->affect_sleep = $input->affect_sleep;
                $added->is_symptoms1 = $input->is_symptoms1;
                $added->is_symptoms2 = $input->is_symptoms2;
                $added->experience_symptoms = $input->experience_symptoms;
                $added->spoken_abt_menopausal = $input->spoken_abt_menopausal;
                $added->cycle_lengths_changed_recently = $input->cycle_lengths_changed_recently;
                $added->duration_period_changed = $input->duration_period_changed;
                $added->bleeding_been_heavier_period = $input->bleeding_been_heavier_period;
                $added->occur_ns = $input->occur_ns;
                $added->nhs_or_private_healthcare = $input->nhs_or_private_healthcare;
                $added->whom_did_you_consult = $input->whom_did_you_consult;
                $added->received_diagnosis_healthcare_professional = $input->received_diagnosis_healthcare_professional;
                $added->on_hormone_replacement_therapy = $input->on_hormone_replacement_therapy;
                $added->which_form_of_HRT_are_you_on = $input->which_form_of_HRT_are_you_on;
                $added->type_of_HRT_routine_are_you_on = $input->type_of_HRT_routine_are_you_on;
                $added->type_of_cyclic_HRT_routine_are_you_on = $input->type_of_cyclic_HRT_routine_are_you_on;
                $added->drinking = $request->drinking;
                $added->exercise = $request->exercise;
                $added->login_id = auth()->id();
                $added->Created_by = auth()->id();
                $added->save();
                // print_r($input);
                // exit;
                $user =User::where('id','=',$add_id)->first();

                    $user->is_report_generated=1;
                    $user->save();


            }
            else{
            $input->save();

                    $user =User::where('id','=',$add_id)->first();
                    $user->is_report_generated=1;
                    $user->save();

            }

           $companies =Report::where('login_id','=',$add_id)->get();

            // if (!empty(public_path('report'))) {
            //     \File::cleanDirectory(public_path('report'));
            // }

            foreach ($companies as $k => $val) {
                $input = $val;
                $pdf = PDF::loadView('report.pdfg', compact('input'));
                $pdf->setPaper('a4', 'portrait');
                $name ='Report_'. $val->login_id . '.pdf';
                $pdf->save(public_path('report/' . $name));
                $url = \URL::to('/') . '/report/' . $name;
               // $input[$k]->pdf_url = $url;
            }


            $pdf_details = ['url' => $url];
            $success['result'] = true;
            $success['data'] = (object) $pdf_details;
            $success['message'] = "Report Generated Pdf Successfully";
            return $this->sendResponse($success);


        }


        } catch (\Exception $e) {
                    $success['result'] = false;
                    $success['message'] = "Something Went Wrong!";
                    return $this->sendResponse($success);
                }




        //return $this->sendResponse($success);
    }
    public function add_symptom(Request $request)
    {

        try {

            $input = new Symptom();
            $input->symptom_id = $request->id;
            $input->title = $request->title;
            $input->key_name = $request->key_name;
            $input->is_selected = false;
             $input->color_code = $request->color_code;

            if($request->source && $request->source != '') {
                $imageName = time().rand(0000,9999).'.'.$request->source->extension();

                $pic = 'assets/images/s_image/'.$imageName;
                $fileType = $request->source->extension();
                $request->source->move(public_path('assets/images/s_image/'), $imageName);
                $temp_path = public_path('assets/images/s_image/'.$imageName);
                $destination = public_path('assets/images/s_image/'.$imageName);
                //$this->resize($temp_path,$destination,300,200);

                $input->source = $pic ;
                $input->source = 'assets/images/s_image/'.$imageName;

            }

            if($request->source_color && $request->source_color != '') {
                $imageName = time().rand(0000,9999).'.'.$request->source_color->extension();

                $pic = 'assets/images/s_image/'.$imageName;
                $fileType = $request->source_color->extension();
                $request->source_color->move(public_path('assets/images/s_image/'), $imageName);
                $temp_path = public_path('assets/images/s_image/'.$imageName);
                $destination = public_path('assets/images/s_image/'.$imageName);
                //$this->resize($temp_path,$destination,300,200);

                $input->source_color = $pic ;
                $input->source_color = 'assets/images/s_image/'.$imageName;

            }
            $input->login_id = auth()->id();
            $input->Created_by = auth()->id();
            $input->save();
            $success['result'] = true;
            $success['message'] = "Symptom Add Successfully";
            return $this->sendResponse($success);

        }
        catch (\Exception $e)
         {
                    $success['result'] = false;
                    $success['message'] = "Something Went Wrong!";
                    return $this->sendResponse($success);
                }




        //return $this->sendResponse($success);
    }
    public function test_pdf()
    {
        $pdf = PDF::loadView('menopause.pdfg');
                $pdf->setPaper('a4', 'landscape');

                return $pdf->stream(
                    'Counter Booking Receipt.pdf',
                    array(
                        'Attachment' => 0
                    )
                );
    }


    public function report_pdf(){
        $pdf = PDF::loadView('report.pdfg');
                $pdf->setPaper('a4', 'landscape');

                return $pdf->stream(
                    'Counter Booking Receipt.pdf',
                    array(
                        'Attachment' => 0
                    )
                );
    }
    public function generate_pdf_menopause(Request $request)
    {

        try {


            $input = new Menopause();
            $input->first_name = $request->first_name;
            $input->age = $request->age;
            $input->weight = $request->weight;
            $input->smoking = $request->smoking;
            $input->drinking = $request->drinking;
            $input->exercise = $request->exercise;
            $input->pdf_generated_date = date('Y-m-d H:i:s');//$request->pdf_generated_date;
            $input->hot_flashes = $request->hot_flashes;
            $input->night_sweats = $request->night_sweats;
            $input->cold_flashes = $request->cold_flashes;
            $input->physchological = $request->physchological;
            $input->physical = $request->physical;
            $input->last_period = $request->last_period;
            $input->cycle_changed = $request->cycle_changed;
            $input->heavier_bleeding = $request->heavier_bleeding;
            $input->my_management = $request->my_management;
            $input->hrt_routine = $request->hrt_routine;
            $input->login_id = auth()->id();
            $input->Created_by = auth()->id();
            $add_id= $input->login_id ;
            $added=Menopause::where('login_id','=',$add_id)->first();
            if($added)
            {

            }
            else{
            $input->save();
            }

           $companies =Menopause::where('login_id','=',$add_id)->get();

            // if (!empty(public_path('pdf'))) {
            //     \File::cleanDirectory(public_path('pdf'));
            // }

            foreach ($companies as $k => $val) {
                $input = $val;
                $pdf = PDF::loadView('menopause.pdfg', compact('input'));
                $pdf->setPaper('a4', 'portrait');
                $name = $val->login_id . '.pdf';
                $pdf->save(public_path('pdf/' . $name));
                $url = \URL::to('/') . '/pdf/' . $name;
               // $input[$k]->pdf_url = $url;
            }


            $pdf_details = ['url' => $url];
            $success['result'] = true;
            $success['data'] = (object) $pdf_details;
            $success['message'] = "Menopause Generated Pdf Successfully";
            return $this->sendResponse($success);


        }
        catch (\Exception $e)
         {
                    $success['result'] = false;
                    $success['message'] = "Something Went Wrong!";
                    return $this->sendResponse($success);
                }




        //return $this->sendResponse($success);
    }

    public function add_user_symptom(Request $request)
    {

        try {
            $symptom_id=$request->symptom_id;
            $symptoms = Symptom::where('symptom_id','=',$request->symptom_id)->first();

            $input = new Usersymptom();
            $input->s_id = $symptoms->id;
            $input->is_selected = 1;
            $input->login_id = auth()->id();
            $input->Created_by = auth()->id();
            $input->save();
            $success['result'] = true;
            $success['message'] = "User Symptom Add Successfully";
            return $this->sendResponse($success);

        }
        catch (\Exception $e)
         {
                    $success['result'] = false;
                    $success['message'] = "Something Went Wrong!";
                    return $this->sendResponse($success);
                }





    }

    public function update_user_symptom(Request $request)
    {

        $login_id = auth()->id();
        try {



            $count=Usersymptom::where('login_id',$login_id)->orderby('id','DESC')
            ->where('ddate',date('Y-m-d'))->where('is_selected',1)->get()->count();

            $check=Usersymptom::where('login_id',$login_id)->orderby('id','DESC')
            ->where('ddate',date('Y-m-d'))->where('is_selected',1)->where('symptom_id',$request->symptom_id)->get()->count();
            if(($count >= 6) && $check == 0)
            {
                $success['result'] = false;
                $success['message'] = "You can`t update more than 6";
                return $this->sendResponse($success);

            }
            $dates = Usersymptom::where('symptom_id',$request->symptom_id)
            ->where('login_id',$login_id)->select('ddate')->orderby('id','DESC')->get()->toArray();

            if(count($dates) > 0)
            {

                $today=Carbon::now()->format('Y-m-d');
                foreach($dates as $date)
                {
                    if($date['ddate'] >= $today)
                    {
                        $symptoms = Usersymptom::where('symptom_id',$request->symptom_id)
                        ->whereDate('ddate',$date['ddate'])->where('login_id',$login_id)->first();

                         if($symptoms->is_selected==1)
                        {
                                $type = 'false';
                                $symptoms->is_selected = false;
                                $symptoms->save();

                        }else{

                            $type = 'true';
                            $symptoms->is_selected = true;
                                $symptoms->save();

                        }

                    }
                }
                $success['result'] = true;
                $success['message'] = "Your Symptom " .$type. " data Update  Successfully";
                return $this->sendResponse($success);
            }else
            {
                $success['result'] = false;
                $success['message'] = "No Record Found With This Id";
                return $this->sendResponse($success);
            }

        } catch (\Exception $e) {
                    $success['result'] = false;
                    $success['message'] = "Something Went Wrong!";
                    return $this->sendResponse($success);
                }




        //return $this->sendResponse($success);
    }
    public function fetch_user_symptom(Request $request)
    {
        $file = fopen('myfile.txt','a+');
                fwrite($file,print_r($request->all(),true));
                fclose($file);
        $us=auth()->id();
        $select=1;
        $date=date('Y-m-d', strtotime($request->date));
        $today=Carbon::now()->format('Y-m-d');

         if($today == $date || $date > $today)
         {
            $symptoms = Usersymptom::where('login_id','=',$us)->whereDate('ddate','=',$today)
            ->where('is_selected','=',$select)->groupBy('symptom_id')->orderby('id','DESC')->get()->toArray();

            if(count($symptoms))
            {

                if($date != $today)
                {
                    foreach($symptoms as $key => $sym)
                    {
                        $symptoms[$key]['ddate']=$date;
                        $symptoms[$key]['none']=false;
                        $symptoms[$key]['progress']=10;
                    }
                }
                $success['result'] = true;
                $success['data'] = $symptoms;
                $success['message'] = "Your Symptom List";
                return $this->sendResponse($success);
            }
        }else if($date < $today)
        {
            $symptoms = Usersymptom::where('login_id','=',$us)->whereDate('ddate','=',$date)
            ->where('is_selected','=',$select)->groupBy('symptom_id')->orderby('id','DESC')->get()->toArray();

            if(count($symptoms))
            {

                $success['result'] = true;
                $success['data'] = $symptoms;
                $success['message'] = "Your Symptom List";
                return $this->sendResponse($success);
            }
            else
        {
                $success['result'] = false;
                $success['message'] = "No Record Found";
                return $this->sendResponse($success);
        }
        }
        else
        {
                $success['result'] = false;
                $success['message'] = "No Record Found";
                return $this->sendResponse($success);
        }




        //}
        // else if($today == $date)
        // {

        //     $symptoms = Usersymptom::where('login_id','=',$us)
        //     ->whereDate('ddate',$date)
        //     ->where('is_selected',$select)
        //     ->groupBy('symptom_id')->orderby('id','DESC')->get()->toArray();
        //     if(count($symptoms))
        //     {


        //         $success['result'] = true;
        //         $success['data'] = $symptoms;
        //         $success['message'] = "Your Symptom List";
        //         return $this->sendResponse($success);


        //     }
        //     else
        //     {

        //         $today=Carbon::now()->format('Y-m-d');
        //         $yesterday = Carbon::yesterday()->format('Y-m-d');



        //             $sym = Usersymptom::where('login_id','=',$us)->whereDate('ddate','=',$yesterday)
        //             ->groupBy('symptom_id')->orderby('id','DESC')
        //             ->get()->toArray();
        //             if(count($sym))
        //             {

        //                     $symtom_list = [];
        //                     foreach($sym as $k => $symptom)
        //                     {



        //                         $usersymptom = new Usersymptom();
        //                         $usersymptom->symptom_id = $symptom['symptom_id'];
        //                         $usersymptom->title = $symptom['title'];
        //                         $usersymptom->key_name = $symptom['key_name'];
        //                         $usersymptom->is_selected = $symptom['is_selected'];
        //                         $usersymptom->source = $symptom['source'];
        //                         $usersymptom->source_color = $symptom['source_color'];
        //                         $usersymptom->color_code = $symptom['color_code'];
        //                         $usersymptom->login_id = auth()->id();
        //                         $usersymptom->Created_by = auth()->id();
        //                         $today=Carbon::now()->format('Y-m-d');
        //                         $usersymptom->ddate = $today;

        //                         $usersymptom->save();

        //                         $usersymptom = Usersymptom::find($usersymptom->id);

        //                         $symtom_list[]=$usersymptom;

        //                     }
        //                     $success['result'] = true;
        //                         $success['data'] = $symtom_list;
        //                         $success['message'] = "Your Symptom List";
        //                         return $this->sendResponse($success);








        //         }
        //         else
        //         {
        //             $success['result'] = false;
        //             $success['message'] = "No Record Found";
        //             return $this->sendResponse($success);
        //         }
        //     }
        // }

        // else
        // {

        //     $symptom = Usersymptom::where('login_id',$us)->whereDate('ddate',$date)
        //     ->where('is_selected',$select)
        //     ->groupBy('symptom_id')->orderby('id','DESC')
        //     ->get()->toArray();

        //     if(count($symptom))
        //     {
        //         $success['result'] = true;
        //         $success['data'] = $symptom;
        //         $success['message'] = "Your Symptom List";
        //         return $this->sendResponse($success);
        //     }
        // else
        // {
        //     $success['result'] = false;
        //     $success['message'] = "No Record Found";
        //     return $this->sendResponse($success);
        // }

        // }



    }







    public function fetch_symptom_progress_count(Request $request)
    {

        $us=auth()->id();
        $select=1;
        $from=date('Y-m-d', strtotime($request->from));
        $to=date('Y-m-d', strtotime($request->to));

        $today=Carbon::now()->format('Y-m-d');

        if($today < $from)
        {

                $symptom = Usersymptom::where('login_id','=',$us)
                ->whereDate('ddate','>=',$to)
                ->whereDate('ddate','<=',$from)
                ->where('is_selected','=',$select)->groupBy('symptom_id')->limit(6)->get()->toArray();


                    // print_r($symptom);
                    // exit;
                    foreach($symptom as $key => $sym)
                    {
                        $symptom_id=$sym['symptom_id'];
                        $progress = Usersymptom::where('login_id','=',$us)->where('symptom_id','=',$symptom_id)->whereDate('ddate','>=',$to)->whereDate('ddate','<=',$from)->where('is_selected','=',$select)->get()->sum('progress');
                        $av = Usersymptom::where('login_id','=',$us)->where('symptom_id','=',$symptom_id)->whereDate('ddate','>=',$to)->whereDate('ddate','<=',$from)->where('is_selected','=',$select)->get()->count();
                        $symptom[$key]['progress']=$progress/$av;

                    }

                    $success['result'] = true;
                    $success['data'] = $symptom;
                    $success['message'] = "Your Symptom List";
                    return $this->sendResponse($success);

        }
        else
        {

            $symptom = Usersymptom::where('login_id','=',$us)->whereDate('ddate','>=',$from)->whereDate('ddate','<=',$to)->where('is_selected','=',$select)->groupBy('symptom_id')->limit(6)->get()->toArray();


            // print_r($symptom);
            // exit;
            foreach($symptom as $key => $sym)
            {
                $symptom_id=$sym['symptom_id'];
                $progress = Usersymptom::where('login_id','=',$us)->where('symptom_id','=',$symptom_id)->whereDate('ddate','>=',$from)->whereDate('ddate','<=',$to)->where('is_selected','=',$select)->get()->sum('progress');
                $av = Usersymptom::where('login_id','=',$us)->where('symptom_id','=',$symptom_id)->whereDate('ddate','>=',$from)->whereDate('ddate','<=',$to)->where('is_selected','=',$select)->get()->count();
                $symptom[$key]['progress']=$progress/$av;

            }

            $success['result'] = true;
            $success['data'] = $symptom;
            $success['message'] = "Your Symptom List";
            return $this->sendResponse($success);

        }

    }





    public function update_user_name(Request $request)
    {

        $name=$request->name;
        $login_id = auth()->id();
        $user = User::where('id','=',$login_id)->first();
        if($user)
        {
                $user->first_name = $name;
                $user->save();


                $success['result'] = true;
                $success['message'] = "User Name Update Successfully";
                return $this->sendResponse($success);
        }
        else
        {
            $success['result'] = false;
            $success['message'] = "User Not Found";
            return $this->sendResponse($success);

        }


    }



    public function delete_user(Request $request)
    {

        $reason=$request->reason;

        $login_id = auth()->id();
        $user = User::where('id','=',$login_id)->first();

        if($user)
        {
           $add= new Dltreason();
            $add->msg=$reason;
            $add->login_id = auth()->id();
            $add->Created_by = auth()->id();
            $add->save();


                $user->delete();


                $success['result'] = true;
                $success['message'] = "User Deleted Successfully";
                return $this->sendResponse($success);
        }
        else
        {

            $success['result'] = false;
            $success['message'] = "User Not Found";
            return $this->sendResponse($success);





        }


    }
    public function change_symptom(Request $request)
    {
        $login_id = auth()->id();
        $today=Carbon::now()->format('Y-m-d');
        $select=1;
        $progress=$request->progress;
        $none = $request->none;
        $symptoms = Usersymptom::where('symptom_id',$request->symptom_id)
        ->whereDate('ddate',$today)->where('login_id',$login_id)
        ->groupby('symptom_id')
        ->where('is_selected',$select)
        ->first();

        if(!empty($symptoms))
        {
            $symptoms->progress = $progress;
            if($none=='Yes')
            {
                $symptoms->none = 1;
            }
            else if($none=='No')
            {
                $symptoms->none = 0;
            }
            else
            {
                $symptoms->none = 0;
            }

            $symptoms->save();
            $success['result'] = true;
            $success['data'] = $symptoms;
            $success['message'] = "Your Symptom Update Successfully";
            return $this->sendResponse($success);
        }
        {
            $success['result'] = false;
            $success['message'] = "No Record Found With This Id";
            return $this->sendResponse($success);
        }
    }
    public function listing_symptom(Request $request)
    {
        $today=Carbon::now()->format('Y-m-d');
        $select=1;
        $login_id = auth()->id();
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        try {
        $count = Usersymptom::where('login_id',$login_id)->whereDate('ddate',$today)->groupBy('symptom_id')->limit(30)->orderby('id','DESC')->get()->count();
        if($count > 0)
        {

            $sym = Usersymptom::where('login_id',$login_id)
            ->whereDate('ddate',$today)->groupBy('symptom_id')
            ->orderby('id','DESC')->get();

            $symtom_list = [];
            foreach($sym as $k => $symptom)
            {
                $usersymptom = Usersymptom::find($symptom['id']);
                if($usersymptom->symptom_id == $symptom->symptom_id)
                {
                    if($symptom->is_selected == 1)
                    {
                        $usersymptom->is_selected = 1;
                    }
                }
                $symtom_list[]=$usersymptom;
            }
                $success['result'] = true;
                $success['data'] = $symtom_list;
                $success['message'] = "Your Symptom List";
                return $this->sendResponse($success);
        }else
        {

                $symptoms=Symptom::get();

                foreach($symptoms as $k => $symptom)
                {

                    $issym = Usersymptom::where('login_id',$login_id)
                    ->where("is_selected",1)
                    ->where("symptom_id",$symptom->symptom_id)
                    ->whereDate('ddate',$yesterday)
                    ->groupBy('symptom_id')
                    ->orderby('id','DESC')
                    ->first();
                    $selected = 0;
                    if(!empty($issym))
                    {
                        $selected = 1;
                    }

                    $usersymptom = new Usersymptom();
                    $usersymptom->symptom_id = $symptom->symptom_id;
                    $usersymptom->title = $symptom->title;
                    $usersymptom->key_name = $symptom->key_name;
                    $usersymptom->is_selected = $selected;
                    $usersymptom->source = $symptom->source;
                    $usersymptom->source_color = $symptom->source_color;
                    $usersymptom->color_code = $symptom->color_code;
                    $usersymptom->login_id = auth()->id();
                    $usersymptom->Created_by =auth()->id();
                    $today=Carbon::now()->format('Y-m-d');
                    $usersymptom->ddate = $today;
                    $usersymptom->save();

                }
                $sym = Usersymptom::where('login_id',$login_id)
                 ->whereDate('ddate',$today)->groupBy('symptom_id')
                ->orderby('id','DESC')->get();
                    $success['result'] = true;
                    $success['data'] = $sym;
                    $success['message'] = "Your Symptom List";
                    return $this->sendResponse($success);
            }

            } catch (\Exception $e) {
            $success['result'] = false;
            $success['message'] = "Something Went Wrong!";
            return $this->sendResponse($success);
        }


    }

    public function test(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'action' => 'required',
        ]);

        if($validator->fails()){
            $success['result'] = "false";
            $success['message'] = $validator->errors()->first();
            return $this->sendResponse($success);
        }



        if($request->action=="add")
        {

            $input = new Test();
            $input->login_id = auth()->id();
            $input->connected = $request->connected;
            $input->disconnected = $request->disconnected;
            $input->firmware = $request->firmware;
            $input->batteryLevel = $request->batteryLevel;
            $input->temperatureValue = $request->temperatureValue;
            $input->dateAndTimeValue = $request->dateAndTimeValue;
            $input->alertLevel = $request->alertLevel;
            $input->alertStatus = $request->alertStatus;
            $input->manufacturerName = $request->manufacturerName;
            $input->modelNumber = $request->modelNumber;
            $input->serialNumber = $request->serialNumber;
            $input->temperature = $request->temperature;
            $input->Created_by = auth()->id();


            $input->save();
          //  print_r('do');
            $success['result'] = true;
            $success['message'] = "Test Add Successfully";
        }
        elseif($request->action=="edit")
        {

           $id=$request->id;

            $test = Test::where('id',$id)->first();


            if($test)
            {

            $test->login_id = auth()->id();
            $test->connected = $request->connected;
            $test->disconnected = $request->disconnected;
            $test->firmware = $request->firmware;
            $test->batteryLevel = $request->batteryLevel;
            $test->temperatureValue = $request->temperatureValue;
            $test->dateAndTimeValue = $request->dateAndTimeValue;
            $test->alertLevel = $request->alertLevel;
            $test->alertStatus = $request->alertStatus;
            $test->manufacturerName = $request->manufacturerName;
            $test->modelNumber = $request->modelNumber;
            $test->serialNumber = $request->serialNumber;
            $test->temperature = $request->temperature;
            $test->Created_by = auth()->id();

                $test->save();

                $success['result'] = true;
                $success['message'] = "test Data Update Successfully";
            }
            else
            {
                $success['result'] = false;
                $success['message'] = "No Record Found With This Id";
            }

        }
        elseif($request->action=="delete")
        {
            $test = Test::where('id',$request->id)->first();
            if($test)
            {
                $test->is_delete =1;
                $test->save();

                $success['result'] = true;
                $success['message'] = "Delete Test Successfully";
            }
            else
            {
                $success['result'] = false;
                $success['message'] = "No Record Found With This Id";
            }

        }
        elseif($request->action=="search")
        {
            $id = $request->id;
            $test = Test::where('id',$id);
            $test = $test->get();
            if(sizeof($test)>0)
            {
                $success['result'] = true;
                $success['data'] = $test;
                $success['message'] = "Test List";
            }
            else
            {
                $success['result'] = false;
                $success['message'] = "No Record Found With This Search";
            }

        }
        else
        {
            $success['result'] = false;
            $success['message'] = "Something Went Wrong!";
        }

        return $this->sendResponse($success);
    }
    public function testnew(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'action' => 'required',
        ]);

        if($validator->fails()){
            $success['result'] = "false";
            $success['message'] = $validator->errors()->first();
            return $this->sendResponse($success);
        }

        if($request->action=="add")
        {

            $data_array = json_decode($request->data_array,true);



            foreach($data_array as $k=>$row)
            {
                $input = new Test();
                $input->login_id = auth()->id();
                $input->connected = isset($row['connected'])?$row['connected']:'';
                $input->disconnected = isset($row['disconnected'])?$row['disconnected']:'';
                $input->firmware = isset($row['firmware'])?$row['firmware']:'';
                $input->batteryLevel = isset($row['batteryLevel'])?$row['batteryLevel']:'';
                $input->temperatureValue = isset($row['temperatureValue'])?$row['temperatureValue']:'';
                $input->dateAndTimeValue = isset($row['dateAndTimeValue'])?$row['dateAndTimeValue']:'';
                $input->alertLevel = isset($row['alertLevel'])?$row['alertLevel']:'';
                $input->alertStatus = isset($row['alertStatus'])?$row['alertStatus']:'';
                $input->manufacturerName = isset($row['manufacturerName'])?$row['manufacturerName']:'';
                $input->modelNumber = isset($row['modelNumber'])?$row['modelNumber']:'';
                $input->serialNumber = isset($row['serialNumber'])?$row['serialNumber']:'';
                $input->temperature = isset($row['temperature'])?$row['temperature']:'';

                $input->diagnosticCommand = isset($row['diagnosticCommand'])?$row['diagnosticCommand']:'';
                $input->diagnosticReport = isset($row['diagnosticReport'])?$row['diagnosticReport']:'';


                $input->Created_by = auth()->id();
                $input->save();
            }
            $success['result'] = true;
            $success['message'] = "Test Add Successfully";
        }
        else
        {
            $success['result'] = false;
            $success['message'] = "Something Went Wrong!";
        }

        return $this->sendResponse($success);
    }

    public function testadd(Request $request)
    {
        $validator = Validator::make($request->all(), [
           // 'action' => 'required',
        ]);

        if($validator->fails()){
            $success['result'] = "false";
            $success['message'] = $validator->errors()->first();
            return $this->sendResponse($success);
        }
        $input = new Test();
        $input->login_id = auth()->id();
        $input->connected = $request->connected;
        $input->disconnected = $request->disconnected;
        $input->firmware = $request->firmware;
        $input->batteryLevel = $request->batteryLevel;
        $input->temperatureValue = $request->temperatureValue;
        $input->dateAndTimeValue = $request->dateAndTimeValue;
        $input->alertLevel = $request->alertLevel;
        $input->alertStatus = $request->alertStatus;
        $input->manufacturerName = $request->manufacturerName;
        $input->modelNumber = $request->modelNumber;
        $input->serialNumber = $request->serialNumber;
        $input->temperature = $request->temperature;
        $input->Created_by = auth()->id();


        $input->save();
      //  print_r('do');
        $success['result'] = true;
        $success['message'] = "Test Add Successfully";
    }
    public function post(Request $request)
    {
        // print_r('s');
        // exit;
        $validator = Validator::make($request->all(), [
            'action' => 'required',
        ]);

        if($validator->fails()){
            $success['result'] = "false";
            $success['message'] = $validator->errors()->first();
            return $this->sendResponse($success);
        }

       // $admin_id = Auth::user()->id;

        if($request->action=="add")
        {

           // $mobile_no = implode(',', json_decode($request->mobile_no));

            $input = new Post();
            $input->category_id = $request->category_id;
            $input->title = $request->title;
            $input->short_desc = $request->short_desc;
            $input->long_desc = $request->long_desc;
          //$input->videos = $request->videos;
            $input->youtube_url = $request->youtube_url;
            $input->approve_status = $request->approve_status;
            $input->reward_points = $request->reward_points;

           //$input->category_image = $request->category_image;
            if($request->videos && $request->videos != '') {
                $imageName = time().rand(0000,9999).'.'.$request->videos->extension();

                $pic = 'assets/images/category_image/'.$imageName;
                $fileType = $request->videos->extension();
                $request->videos->move(public_path('assets/images/category_image/'), $imageName);
                $temp_path = public_path('assets/images/category_image/'.$imageName);
                $destination = public_path('assets/images/category_image/'.$imageName);
                //$this->resize($temp_path,$destination,300,200);

                $input->videos = $pic ;
                $input->videos = 'assets/images/category_image/'.$imageName;

            }
            $input->Created_by = 1 ;


            $input->save();
           // print_r('do');
            $success['result'] = true;
            $success['message'] = "Post Add Successfully";
        }
        elseif($request->action=="edit")
        {

           $id=$request->id;

            $post = Post::where('id',$id)->first();


            if($post)
            {

            $post->category_id = $request->category_id;
            $post->title = $request->title;
            $post->short_desc = $request->short_desc;
                $post->long_desc = $request->long_desc;
                $post->youtube_url = $request->youtube_url;
                $post->approve_status = $request->approve_status;
                $post->reward_points = $request->reward_points;

                if($post->videos != null && $request->videos != null && $request->videos != '') {
                    if(file_exists(public_path().'/'.$category->videos))
                    {
                        unlink(public_path().'/'.$category->videos);
                    }
                }
                //save new category image
                if($request->videos && $request->videos != '') {
                    $imageName = time().rand(0000,9999).'.'.$request->videos->extension();

                    $pic = 'assets/images/category_image/'.$imageName;
                    $fileType = $request->videos->extension();
                    $request->videos->move(public_path('assets/images/category_image/'), $imageName);
                    $temp_path = public_path('assets/images/category_image/'.$imageName);
                    $destination = public_path('assets/images/category_image/'.$imageName);
                    $this->resize($temp_path,$destination,300,200);

                    $post->videos = $pic ;
                    $post->videos = 'assets/images/category_image/'.$imageName;
                }
                $post->Created_by = 1;


                $post->save();

                $success['result'] = true;
                $success['message'] = "Post Data Update Successfully";
            }
            else
            {
                $success['result'] = false;
                $success['message'] = "No Record Found With This Id";
            }

        }
        elseif($request->action=="delete")
        {
            $post = Post::where('id',$request->id)->first();
            if($post)
            {
                $post->is_delete =1;
                $post->save();

                $success['result'] = true;
                $success['message'] = "Delete post Successfully";
            }
            else
            {
                $success['result'] = false;
                $success['message'] = "No Record Found With This Id";
            }

        }
        elseif($request->action=="search")
        {
            $id = $request->id;
            $post = Post::where('id',$id);
            $post = $post->get();
            if(sizeof($post)>0)
            {
                $success['result'] = true;
                $success['data'] = $post;
                $success['message'] = "post List";
            }
            else
            {
                $success['result'] = false;
                $success['message'] = "No Record Found With This Search";
            }

        }
        else
        {
            $success['result'] = false;
            $success['message'] = "Something Went Wrong!";
        }

        return $this->sendResponse($success);
    }
    public function alerthours(Request $request)
    {
        $user_id=auth()->id();
        $from=date('Y-m-d', strtotime($request->from));
        $to=date('Y-m-d', strtotime($request->to));
        $dates = $this->date_range($request->from,$request->to);
        $hours_list = [];
        foreach($dates as $date)
        {
            $hours=[];
            $data=Test::where('login_id',$user_id)
                ->where('alertLevel',1)
                ->whereDate('created_at','>=',$date." 00:00:00")
                ->whereDate('created_at','<=',$date." 23:59:59")
                ->select('created_at')
                ->get()->toArray();
            foreach($data as $row)
            {
                $h =date('h',strtotime($row['created_at']));
                $m =  date('i',strtotime($row['created_at']));
                $hours[] = floatval($h.".".$m);

            }
            $day = date('l',strtotime($date));
            if(isset($hours))
            {
                $hours_list[$day] = $hours; //count($hours);
            }else
            {
                $hours_list[$day] = 0;
            }
        }
        if(count($hours_list) > 0)
        {
            $success['result'] = true;
                $success['data'] = $hours_list;
                $success['message'] = "hours List";
        }else{
            $success['result'] = false;
            $success['message'] = "No Record Found On This Date";
        }
        return $this->sendResponse($success);
    }
    public function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }
    public function ble_address(Request $req)
    {
        try
        {
            $validator = Validator::make($req->all(), [
                'address'=>'required',
                'user_id'=>'required',
            ]);

            if($validator->fails()){
                $success['result'] = "false";
                $success['message'] = $validator->errors()->first();
                return $this->sendResponse($success);
            }


            $user_id=$req->user_id;


            $ble_address = $req->address;

            $search = array('user_id'=>$user_id,'ble_address'=>$ble_address);

            $count = BleAddress::where($search)->get()->count();

            if($count > 0)
            {
                    $add = BleAddress::firstOrCreate($search);
                    $add->user_id = $user_id;
                    $add->ble_address = $ble_address;
                    $add->save();

            }else
            {

                $search = array('user_id'=>$user_id);

                $count = BleAddress::where($search)->get()->count();

                if($count > 0)
                {
                    $success['result'] = false;
                    $success['message'] = "Address already exist please delete it first!";
                    return $this->sendResponse($success);
                }else
                {
                    $add =new BleAddress;
                    $add->user_id = $user_id;
                    $add->ble_address = $ble_address;
                    $add->save();
                }

            }

            $success['result'] = true;
            $success['message'] = "Saved Successfully !";
            return $this->sendResponse($success);

        }catch(\Exception $e)
        {
            echo $e->getMessage();
            $success['result'] = false;
            $success['message'] = "Something Went Wrong!";
            return $this->sendResponse($success);
        }




    }
    public function ble_address_delete(Request $req)
    {
        try{
        $validator = Validator::make($req->all(), [
            'id'=>'required|exists:ble_address',
        ]);

        if($validator->fails()){
            $success['result'] = "false";
            $success['message'] = $validator->errors()->first();
            return $this->sendResponse($success);
        }

        $id = $req->id;
        BleAddress::find($id)->delete();

        $success['result'] = true;
        $success['message'] = "Deleted Successfully !";
        return $this->sendResponse($success);

        }catch(\Exception $e) {
            $success['result'] = false;
            $success['message'] = "Something Went Wrong!";
            return $this->sendResponse($success);
        }
    }
    public function ota_file(Request $req)
    {
        try{
           $data = \DB::table('ota_files')->where('id',1)->first();

            $success['result'] = true;
            $success['message'] = "OTA files !";
            $success['data'] = $data;
            return $this->sendResponse($success);

            }catch(\Exception $e) {
                $success['result'] = false;
                $success['message'] = "Something Went Wrong!";
                return $this->sendResponse($success);
            }
    }
}
