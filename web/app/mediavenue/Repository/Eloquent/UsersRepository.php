<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Auth;
use Carbon\Carbon;
use Hash;
use Mediavenue\Mailers\UserMailer;
use Mediavenue\Repository\PostsRepositoryInterface;
use Mediavenue\Repository\UsersRepositoryInterface;
use User;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface {

    /**
     * @var \Mediavenue\Mailers\Mailer
     */
    private $mailer;
    /**
     * @var \User
     */
    private $user;
    /**
     * @var PostsRepositoryInterface
     */
    private $post;

    /**
     * @param User                           $user
     * @param \Mediavenue\Mailers\UserMailer $mailer
     * @param PostsRepositoryInterface       $post
     */
    public function __construct(User $user, UserMailer $mailer, PostsRepositoryInterface $post)
    {

        $this->mailer = $mailer;
        $this->model = $user;
        $this->post = $post;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $user = $this->model->whereId($id)->first();

        return $user;
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getByUsername($username)
    {
        $user = $this->model->whereUsername($username)->first();

        return $user;
    }

    /**
     * @param $input
     * @return bool
     */
    public function updatePassword($input)
    {
        if (Hash::check($input['currentpassword'], Auth::user()->password))
        {
            $user = Auth::user();
            $user->password = Hash::make($input['password']);
            $user->save();

            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * @param array $input
     * @return bool
     */
    public function create(array $input)
    {
        $activationCode = sha1(str_random(11) . (time() * rand(2, 2000)));

        $this->model->username = $input['username'];
        $this->model->fullname = $input['fullname'];
        $this->model->gender = $input['gender'];
        $this->model->email = $input['email'];
        $this->model->password = Hash::make($input['password']);
        $this->model->confirmed = $activationCode;
        $this->model->save();

        $this->mailer->activation($this->model, $activationCode);

        return true;
    }

    /**
     * @param $username
     * @param $activationCode
     * @return bool
     */
    public function activate($username, $activationCode)
    {
        $user = $this->model->where('username', '=', $username)->first();
        if ($user->confirmed === $activationCode)
        {
            $user->confirmed = 1;
            $user->save();

            return $user;
        }

        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function notifications($id)
    {
        $user = $this->model->whereId($id)->with('notifications')->first();
        $notices = $user->notifications()->orderBy('created_at', 'desc')->paginate(perPage());
        foreach ($notices as $notice)
        {
            if ( ! $notice->seen_at)
            {
                $notice->seen_at = Carbon::now();
                $notice->save();
            }


        }

        return $notices;
    }

    /**
     * @return mixed
     */
    public function getFeeds()
    {
        $following = Auth::user()->following()->lists('follow_id');
        if ( ! $following) $following = [null];

        return $this->post->getFeedsForUser($following);
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getFollowers($user)
    {
        $follower = $user->followers()->lists('user_id');
        if ( ! $follower) $follower = [null];

        return $this->model->whereIn('id', $follower)->with('comments', 'posts')->paginate(perPage());
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getFollowing($user)
    {
        $following = $user->following()->lists('follow_id');
        if ( ! $following) $following = [null];

        return $this->model->whereIn('id', $following)->with('comments', 'posts')->paginate(perPage());
    }

    /**
     * @param array $input
     * @param null  $session
     * @return bool
     */
    public function createFacebookUser(array $input, $session = null)
    {
        if ( ! $session) return;
        $user = $this->getNew();
        $user->username = $input['username'];
        $user->password = Hash::make($input['password']);
        $user->fbid = $session['id'];
        $user->email = $session['email'];
        if (isset($session['gender']))
            $user->gender = $session['gender'];
        $user->fullname = $session['name'];
        $user->confirmed = 1;
        $user->save();
        Auth::loginUsingId($user->id);

        return true;
    }

    /**
     * @param array $input
     * @param null  $session
     * @return bool
     */
    public function createGoogleUser(array $input, $session = null)
    {
        if ( ! $session) return;
        $user = $this->getNew();
        $user->username = $input['username'];
        $user->password = Hash::make($input['password']);
        $user->gid = $session['id'];
        $user->email = $session['email'];
        if (isset($session['gender']))
            $user->gender = $session['gender'];
        $user->fullname = $session['name'];
        $user->confirmed = 1;
        $user->save();
        Auth::loginUsingId($user->id);

        return true;
    }
}