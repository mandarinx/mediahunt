<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Mailers;

use User;

class UserMailer extends Mailer {

    /**
     * @param User $user
     * @param      $activationCode
     */
    public function activation(User $user, $activationCode)
    {
        $subject = "Welcome";
        $view = 'emails.registration.welcome';
        $data = [
            'fullname'       => $user->fullname,
            'username'       => $user->username,
            'activationcode' => $activationCode
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }


    /**
     * @param User $to
     * @param User $from
     */
    public function followMail(User $to, User $from)
    {
        if ( ! $to->email_follow) return;

        $subject = "New Follower";
        $view = 'emails.usermailer.follow';
        $data = [
            'senderFullname'    => ucfirst(e($from->fullname)),
            'senderProfileLink' => route('user', ['username' => $from->username])
        ];

        return $this->sendTo($to, $subject, $view, $data);
    }

}