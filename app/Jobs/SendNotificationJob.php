<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\Traits\NotificationTrait;

class SendNotificationJob implements ShouldQueue
{
    
    use NotificationTrait, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification_data;
    protected $fcm_token_array;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fcm_token_array, $notification_data)
    {
        $this->fcm_token_array = $fcm_token_array;
        $this->notification_data = $notification_data;
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        $result =  $this->send_push_notification($this->fcm_token_array, $this->notification_data);
        
        return $result;
    }

}
