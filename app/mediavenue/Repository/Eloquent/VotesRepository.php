<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Auth;
use Mediavenue\Notifier\PostNotifer;
use Mediavenue\Repository\PostsRepositoryInterface;
use Mediavenue\Repository\VotesRepositoryInterface;
use Post;
use Votes;

class VotesRepository extends AbstractRepository implements VotesRepositoryInterface {

    /**
     * @param Votes                    $model
     * @param PostsRepositoryInterface $posts
     * @param PostNotifer              $notifier
     */
    public function  __construct(Votes $model, PostsRepositoryInterface $posts, PostNotifer $notifier)
    {
        $this->model = $model;
        $this->post = $posts;
        $this->notifier = $notifier;
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function vote(Post $post)
    {
        $vote = $this->getNew();
        $vote->post_id = $post->id;
        $vote->user_id = Auth::user()->id;
        $vote->save();

        $this->notifier->vote($post, Auth::user());

        return true;
    }
}