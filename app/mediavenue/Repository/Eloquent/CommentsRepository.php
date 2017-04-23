<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Auth;
use Comment;
use CommentsVotes;
use Mediavenue\Notifier\PostNotifer;
use Mediavenue\Repository\CommentsRepositoryInterface;
use Mediavenue\Repository\PostsRepositoryInterface;


/**
 * Class CommentsRepository
 *
 * @package Mediavenue\Repository\Eloquent
 */
class CommentsRepository extends AbstractRepository implements CommentsRepositoryInterface {


    /**
     * @var \Comment
     */
    protected $model;
    /**
     * @var \Mediavenue\Repository\PostsRepositoryInterface
     */
    private $posts;
    /**
     * @var \Mediavenue\Notifier\PostNotifer
     */
    private $notifications;
    /**
     * @var CommentsVotes
     */
    private $vote;

    /**
     * @param Comment                          $comment
     * @param \Mediavenue\Notifier\PostNotifer $notifications
     * @param PostsRepositoryInterface         $posts
     * @param CommentsVotes                    $vote
     */
    public function  __construct(Comment $comment, PostNotifer $notifications, PostsRepositoryInterface $posts, CommentsVotes $vote)
    {

        $this->model = $comment;
        $this->posts = $posts;
        $this->notifications = $notifications;
        $this->vote = $vote;
    }

    /**
     * @param $id
     * @return bool
     */
    public function getById($id)
    {
        $comment = $this->model->whereId($id)->first();
        if ( ! $comment)
        {
            return false;
        }

        return $comment;
    }

    /**
     * @param $postId
     * @param $input
     * @return bool
     */
    public function create($postId, array $input)
    {
        $post = $this->posts->getById($postId);
        if ( ! $post)
        {
            return false;
        }
        $comment = $this->getNew();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $postId;
        $comment->description = $input['comment'];
        $comment->save();
        if (Auth::user()->id != $post->user_id)
        {
            $this->notifications->comment($post, Auth::user(), 'comment', $input['comment']);
        }

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $comment = $this->model->where('id', '=', $id)->first();
        if ( ! $comment)
        {
            return false;
        }
        if ($comment->user_id == Auth::user()->id || Auth::user()->id == $comment->image->user->id)
        {
            $comment->reply()->delete();
            $comment->delete();

            return true;
        }

        return false;
    }

    /**
     * @param $commentId
     * @return mixed
     */
    public function vote($commentId)
    {
        $vote = $this->vote->newInstance();
        $vote->comment_id = $commentId;
        $vote->user_id = Auth::user()->id;
        $vote->save();

        return $vote;
    }

    /**
     * @param $commentId
     * @return bool
     */
    public function deleteVote($commentId)
    {
        $vote = $this->vote->where('comment_id', '=', $commentId)->first();
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