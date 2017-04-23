<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Mailers;

use Post;
use User;

class PostMailer extends Mailer {

    /**
     * @param User $to
     * @param User $sender
     * @param      $comment
     * @param      $link
     */
    public function commentMail(User $to, User $sender, $comment, $link)
    {
        if ( ! $to->email_comment) return;

        $subject = "New Comment";
        $view = 'emails.usermailer.comment';
        $data = [
            'fullname' => ucfirst(e($to->fullname)),
            'from'     => ucfirst(e($sender->fullname)),
            'comment'  => e($comment),
            'link'     => $link
        ];

        return $this->sendTo($to, $subject, $view, $data);
    }

    /**
     * @param User $to
     * @param User $from
     * @param Post $on
     * @param      $reply
     */
    public function replyMail(User $to, User $from, Post $on, $reply)
    {
        if ( ! $to->email_reply) return;

        $subject = 'New Reply';
        $view = 'emails.usermailer.reply';
        $data = [
            'senderFullname'    => ucfirst(e($from->fullname)),
            'senderProfileLink' => url('user/' . $from->username),
            'postTitle'         => ucfirst(e($on->title)),
            'postLink'          => route('post', ['id' => $on->id, 'slug' => $on->slug]),
            'reply'             => e($reply),
        ];

        return $this->sendTo($to, $subject, $view, $data);
    }

    /**
     * @param User $to
     * @param User $from
     * @param Post $on
     */
    public function voteMail(User $to, User $from, Post $on)
    {
        if ( ! $to->email_vote) return;

        $subject = 'Vote';
        $view = 'emails.usermailer.vote';
        $data = [
            'from'  => ucfirst(e($from->fullname)),
            'title' => ucfirst(e($on->title)),
            'link'  => route('post', ['id' => $on->id, 'slug' => $on->slug])
        ];

        return $this->sendTo($to, $subject, $view, $data);
    }
}