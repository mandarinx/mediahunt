<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Repository\UsersRepositoryInterface;
use Mediavenue\Validator\UsersValidator;

class UsersController extends BaseController {

    public function __construct(UsersRepositoryInterface $user, UsersValidator $validator)
    {
        $this->user = $user;
        $this->validator = $validator;
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getUser($username)
    {
        $user = $this->user->getByUsername($username);

        if ( ! $user)
            return Redirect::route('home')->with('flashError', t('Nothing Found'));

        $posts = $user->posts()->whereNotIn('type', ['blog', 'link'])->with('comments', 'votes', 'user', 'category')->orderBy('approved_at', 'desc')->paginate(perPage());

        return View::make('user/user', compact('user', 'posts'));
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        return View::make('user/settings');
    }

    /**
     * @return mixed
     */
    public function updateProfile()
    {
        if ( ! $this->validator->validUpdate(Input::all()))
            return Redirect::route('settings')->withErrors($this->validator->errors())->withInput(Input::all());

        Auth::user()->fullname = Input::get('fullname');
        Auth::user()->gender = Input::get('gender');
        Auth::user()->fb_link = Input::get('fbLink');
        Auth::user()->tw_link = Input::get('twLink');
        Auth::user()->blogurl = Input::get('blogurl');
        Auth::user()->save();

        return Redirect::route('settings')->with('flashSuccess', 'Your profile is now updated');
    }

    /**
     * @return mixed
     */
    public function mailsettings()
    {
        if ( ! $this->validator->validEmailUpdate(Input::all()))
            return Redirect::to('settings')->withErrors($this->validator->errors());
        Input::get('emailcomment') ? Auth::user()->email_comment = 1 : Auth::user()->email_comment = 0;
        Input::get('emailreply') ? Auth::user()->email_reply = 1 : Auth::user()->email_reply = 0;
        Input::get('emailfavorite') ? Auth::user()->email_follow = 1 : Auth::user()->email_follow = 0;
        Input::get('emailfollow') ? Auth::user()->email_vote = 1 : Auth::user()->email_vote = 0;
        Auth::user()->save();

        return Redirect::back()->with('flashSuccess', 'Your profile is now updated');
    }

    /**
     * @return mixed
     */
    public function changePassword()
    {
        if ( ! $this->validator->validPasswordUpdate(Input::all()))
            return Redirect::to('settings')->withErrors($this->validator->errors());

        if ( ! $this->user->updatePassword(Input::all()))
            return Redirect::to('settings')->with('flashError', t('Old password is not valid'));

        return Redirect::to('settings')->with('flashSuccess', t('Your password is updated'));
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        $notifications = $this->user->notifications(Auth::user()->id);

        return View::make('user/notifications', compact('notifications'));
    }

    /**
     * @return mixed
     */
    public function updateAvatar()
    {
        if ( ! $this->validator->validAvatarUpdate(Input::all()))
            return Redirect::back()->withErrors($this->validator->errors());

        if ( ! Input::hasFile('avatar'))
            return Redirect::back()->with('flashError', t('Please try again'));

        $name = $this->dirName() . '.' . Input::file('avatar')->getClientOriginalExtension();
        $success = Input::file('avatar')->move('avatars', $name);
        if ($success)
        {
            Auth::user()->avatar = $name;
            Auth::user()->save();

            return Redirect::back()->with('flashSuccess', t('Avatar is now updated'));
        }

        return Redirect::back()->with('flashError', t('Please try again'));
    }

    /**
     * @return string
     */
    protected function dirName()
    {
        $str = str_random(9);
        if (file_exists(public_path() . '/uploads/' . $str))
        {
            $str = $this->dirName();
        }

        return $str;
    }

    /**
     * @return mixed
     */
    public function getFeeds()
    {
        $posts = $this->user->getFeeds();
        $title = t('Feeds');

        return View::make('post/list', compact('posts', 'title'));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getFollowers($username)
    {
        $user = $this->user->getByUsername($username);
        $title = t('Followers');

        $followers = $this->user->getFollowers($user);


        return View::make('user/followers', compact('user', 'title', 'followers'));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getFollowing($username)
    {
        $user = $this->user->getByUsername($username);
        $title = t('Followers');
        $followers = $this->user->getFollowing($user);

        return View::make('user/followers', compact('user', 'title', 'followers'));
    }
}