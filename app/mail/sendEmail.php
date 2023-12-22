<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class sendEmail extends Mailable
{
    use Queueable, SerializesModels;
  
    public $mail_details;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_details)
    {
        $this->mail_details = $mail_details;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from RUMedical')
                    ->view('emails.myTestMail');
    }
}