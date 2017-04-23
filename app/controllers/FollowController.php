<?php
use Mediavenue\Repository\FollowRepositoryInterface;

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class FollowController extends BaseController {

    /**
     * @var Mediavenue\Repository\FollowRepositoryInterface
     */
    protected $follow;

    /**
     * @param FollowRepositoryInterface $follow
     */
    public function  __construct(FollowRepositoryInterface $follow)
    {
        $this->follow = $follow;
    }

    /**
     * @return mixed|string
     */
    public function follow()
    {
        if (Auth::check() == false) return t('Login First');

        if ( ! Request::ajax()) return t('can\'t follow');

        if ( ! Input::get('id')) return t('can\'t follow');

        return $this->follow->follow(Input::get('id'));
    }
}