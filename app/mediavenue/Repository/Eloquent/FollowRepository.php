<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Auth;
use Followers;
use Mediavenue\Notifier\FollowNotifier;
use Mediavenue\Repository\FollowRepositoryInterface;
use Mediavenue\Repository\UsersRepositoryInterface;


class FollowRepository extends AbstractRepository implements FollowRepositoryInterface {

    /**
     * @var Follow
     */
    protected $model;

    /**
     * @var \Mediavenue\Repository\UsersRepositoryInterface
     */
    private $user;

    /**
     * @param \Followers                          $model
     * @param UsersRepositoryInterface            $user
     * @param \Mediavenue\Notifier\FollowNotifier $followNotifier
     */
    public function  __construct(Followers $model, UsersRepositoryInterface $user, FollowNotifier $followNotifier)
    {

        $this->model = $model;
        $this->user = $user;
        $this->followNotifier = $followNotifier;
    }

    /**
     * @param $id
     * @return string
     */
    public function follow($id)
    {
        $user = $this->user->getById($id);
        if (Auth::user()->id == $id)
        {
            return t("Can't follow");
        }
        if ( ! $user)
        {
            return t("Can't follow");
        }

        // Check if following
        // IF true then un-follow
        $isFollowing = $this->model->where('user_id', '=', Auth::user()->id)->where('follow_id', '=', $user->id);
        if ($isFollowing->count() >= 1)
        {
            $isFollowing->delete();

            return t('Un Followed');
        }

        $follow = $this->getNew();
        $follow->user_id = Auth::user()->id;
        $follow->follow_id = $user->id;
        $follow->save();

        $this->followNotifier->follow($user, Auth::user());

        return t('Following');
    }
}