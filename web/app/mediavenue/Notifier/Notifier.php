<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Notifier;

use Notifications;

abstract class Notifier {

    /**
     * @param $to
     * @param $from
     * @param $type
     * @param $reason
     * @param $on_id
     */
    public function sendNew($to, $from, $type, $reason, $on_id)
    {
        $this->notification = new Notifications();
        $this->notification->user_id = $to;
        $this->notification->from_id = $from;
        $this->notification->type = $type;
        $this->notification->reason = $reason;
        $this->notification->on_id = $on_id;
        $this->notification->save();
    }
}