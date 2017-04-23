<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Auth;
use Flags;
use Mediavenue\Repository\FlagsRepositoryInterface;
use Post;
use User;

class FlagsRepository extends AbstractRepository implements FlagsRepositoryInterface {

    /**
     * @var \Flags
     */
    protected $model;

    /**
     * @param Flags $flags
     */
    public function  __construct(Flags $flags)

    {
        $this->model = $flags;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->whereId($id)->first();
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param Post $post
     * @param      $reason
     * @return bool
     */
    public function report(Post $post, $reason)
    {
        $report = $this->getNew();
        $report->post_id = $post->id;
        $report->type = $post->type;
        $report->user_id = Auth::user()->id;
        $report->reason = $reason;
        $report->reported_user = null;
        $report->save();

        return true;
    }

    /**
     * @param User $user
     * @param      $reason
     * @return bool
     */
    public function reportUser(User $user, $reason)
    {
        $report = $this->getNew();
        $report->post_id = null;
        $report->reported_user = $user->id;
        $report->type = 'user';
        $report->user_id = Auth::user()->id;
        $report->reason = $reason;
        $report->save();

        return true;
    }
}