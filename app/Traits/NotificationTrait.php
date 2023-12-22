<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Sitesetting;
use App\User;
use App\Notification;
use App\Jobs\SendNotificationJob;


trait NotificationTrait
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    function send_push_notification($registatoin_ids, $message)
    {
       

        $androidFcmKey = 'AAAADr9mKsY:APA91bGZfQLt4KUSpZrpqkxR8okYH2-zfDtksaJ0AHqRfwjNjkqOjC3R-zRg-UTmKa9O21-aUhP_nuBal_iqXzH9o2mi9UnqNW_4G8RH1JnQ0jrNfNAvhnou9H1CbUVpGOV39U-Gjdlr';

       

        //create notification record
        $user_ids = User::whereIn('fcm_token', $registatoin_ids)->get()->pluck('id')->toArray();
        // print_r($user_ids);
        // exit;
        $create_notification_data = [];
        $now = now();
        $json_message = json_encode($message);
        foreach ($user_ids as $user_id) {
            $create_notification_data[] = [
                'login_id' => $user_id,
                'msg' => $json_message,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        Notification::insert($create_notification_data);
        //END create notification records

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'notification' => $message,
        );



        $headers = array(
            'Authorization:  key=' . $androidFcmKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);


        // print_R($result);
        // exit;

        if ($result === FALSE) {
        }

        $errormsg = curl_error($ch);
        //dd($errormsg);
        curl_close($ch);

        return $result;
    }

    function allUserNotification($notification_data)
    {
        
        // $notification_data = array(
        //     'type' => 'forum_upload',
        //     'title' => 'new forum Uploaded',
        //     'body' => $forum->title,
        // );

        $result = [];
        //SEND NOTIFICATION WITH JOB OF 1000 USERS
        User::whereNotNull('fcm_token')
            ->chunk(1000, function ($users) use ($notification_data) {
                $fcm_token_array = $users->pluck('fcm_token')->toArray();
                
                // $result =  $this->send_push_notification($fcm_token_array, $notification_data);
                $result[] = dispatch(new SendNotificationJob($fcm_token_array, $notification_data));
            });

        // \Log::info(json_encode($result));
      
        return $result;
    }
}
