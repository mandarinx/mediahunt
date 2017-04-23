<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Notifier;

use Mediavenue\Mailers\UserMailer;
use User;

class FollowNotifier extends Notifier {

    /**
     * @param UserMailer $mailer
     */
    public function __construct(UserMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param User $to
     * @param User $from
     */
    public function follow(User $to, User $from)
    {
        $this->sendNew($to->id, $from->id, 'user', 'follow', null);

        $this->mailer->followMail($to, $from);
    }
}
