<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Mailers;

use Illuminate\Support\Facades\Config;
use Mail;

abstract class Mailer {

    /**
     * @param       $user
     * @param       $subject
     * @param       $view
     * @param array $data
     */
    public function sendTo($user, $subject, $view, $data = [])
    {
        if (Config::get('mail.from.address'))
        {
            $email = $user->email;
            Mail::queue($view, $data, function ($message) use ($email, $subject)
            {
                $message->to($email)->subject($subject);
            });
        }
    }
}