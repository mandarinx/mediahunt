<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Notifier;

use Mediavenue\Mailers\PostMailer;
use Post;
use User;

class PostNotifer extends Notifier {


    /**
     * @param PostMailer $mailer
     */
    public function __construct(PostMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Post $post
     * @param User $from
     * @param      $reason
     * @param      $comment
     */
    public function comment(Post $post, User $from, $reason, $comment)
    {
        $this->sendNew($post->user_id, $from->id, $post->type, $reason, $post->id);

        $to = $post->user;
        $comment = $comment;
        $link = route('post', ['id' => $post->id, 'slug' => $post->slug]);

        $this->mailer->commentMail($to, $from, $comment, $link);
    }

    /**
     * @param \Post $post
     * @param User  $from
     */
    public function vote(Post $post, User $from)
    {
        if ($post->user_id !== $from->id)
            $this->sendNew($post->user_id, $from->id, 'post', 'vote', $post->id);

        $this->mailer->voteMail($post->user, $from, $post);
    }


    /**
     * @param User $to
     * @param User $from
     * @param Post $on
     * @param      $reply
     */
    public function replyNotice(User $to, User $from, Post $on, $reply)
    {
        $this->sendNew($to->id, $from->id, $on->type, 'reply', $on->id);
        $this->mailer->replyMail($to, $from, $on, $reply);
    }
}