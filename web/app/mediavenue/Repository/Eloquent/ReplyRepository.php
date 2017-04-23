<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Auth;
use Mediavenue\Notifier\PostNotifer;
use Mediavenue\Repository\CommentsRepositoryInterface;
use Mediavenue\Repository\ReplyRepositoryInterface;
use Reply;
use ReplyVotes;


class ReplyRepository extends AbstractRepository implements ReplyRepositoryInterface {

    /**
     * @var \Reply
     */
    protected $model;
    /**
     * @var \Mediavenue\Repository\CommentsRepositoryInterface
     */
    private $comment;
    /**
     * @var \Mediavenue\Mailers\PostMailer
     */
    private $mailer;
    /**
     * @var ReplyVotes
     */
    private $votes;

    /**
     * @param Reply                            $reply
     * @param CommentsRepositoryInterface      $comment
     * @param \Mediavenue\Notifier\PostNotifer $notification
     * @param ReplyVotes                       $vote
     */
    public function  __construct(Reply $reply, CommentsRepositoryInterface $comment, PostNotifer $notification, ReplyVotes $vote)
    {
        $this->model = $reply;
        $this->comment = $comment;
        $this->notification = $notification;
        $this->vote = $vote;
    }

    /**
     * @param $id
     * @return bool
     */
    public function getById($id)
    {
        $reply = $this->model->whereId($id)->first();
        if ( ! $reply)
        {
            return false;
        }

        return $reply;
    }

    /**
     * @param array $input
     * @return mixed
     */
    public function create(array $input)
    {
        $comment = $this->comment->getById($input['reply_msgid']);
        if ( ! $comment)
        {
            return false;
        }
        $reply = $this->getNew();
        $reply->comment_id = $input['reply_msgid'];
        $reply->user_id = Auth::user()->id;
        $reply->post_id = $comment->post_id;
        $reply->description = $input['textcontent'];
        $reply->save();

        if ($reply->comment->user->id != Auth::user()->id)
        {
            $this->notification->replyNotice($reply->comment->user, Auth::user(), $comment->post, $input['textcontent']);
        }

        $noticeSentToUsers = [];

        foreach ($this->model->whereCommentId($reply->comment_id)->get() as $replier)
        {
            if ($replier->user_id != Auth::user()->id AND $replier->user_id != $comment->user_id && ! in_array($replier->user_id, $noticeSentToUsers))
            {
                $this->notification->replyNotice($replier->user, Auth::user(), $comment->post, 'SOMETHING');
                $noticeSentToUsers[] = $replier->user_id;
            }
        }

        return $reply;
    }

    /**
     * @param $input
     * @return bool
     */
    public function delete($input)
    {
        $reply = $this->model->where('id', '=', $input)->first();
        if ( ! $reply)
        {
            return false;
        }
        if ($reply->user_id == Auth::user()->id || $reply->comment->user->id == Auth::user()->id || $reply->image->user->id == Auth::user()->id)
        {
            $reply->delete();

            return true;
        }
    }

    /**
     * @param $replyId
     * @return mixed
     */
    public function vote($replyId)
    {
        $vote = $this->vote->newInstance();
        $vote->reply_id = $replyId;
        $vote->user_id = Auth::user()->id;
        $vote->save();

        return $vote;
    }

    /**
     * @param $replyId
     * @return bool
     */
    public function deleteVote($replyId)
    {
        $vote = $this->vote->whereReplyId($replyId)->first();
        if ( ! $vote)
        {
            return false;
        }
        if ($vote->user_id == Auth::user()->id)
        {
            $vote->delete();

            return true;
        }

        return false;
    }
}