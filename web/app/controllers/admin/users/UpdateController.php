<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Controllers\Admin\Users;

use Carbon\Carbon;
use File;
use Hash;
use Input;
use Notifications;
use Redirect;
use Report;
use Request;
use User;
use Validator;
use View;

class UpdateController extends \BaseController {

    /**
     * Update and delete user
     *
     * @return mixed
     */
    public function updateUser()
    {
        $user = User::whereId(Input::get('userid'))->first();
        if ( ! $user) return Redirect::to('admin')->with('flashError', 'No user is associated with this id');

        if (Input::get('delete'))
        {
            // Grab all the image of user
            $posts = $user->posts()->get();

            foreach ($posts as $post)
            {
                // Remove all favorites from that image
                $post->votes()->delete();
                // Remove all comment from that image
                $comments = $post->comments()->delete();
                foreach ($comments as $comment)
                {
                    $comment->reply()->delete();
                    $comment->delete();
                }
                // Delete the image
                $post->flags()->delete();
                File::delete('uploads/' . $post->thumbnail . '.jpeg');
                $post->delete();
            }
            // Delete all comments and reply of this user
            $comments = $user->comments()->get();
            foreach ($comments as $comment)
            {
                $comment->reply()->delete();
                $comment->delete();
            }
            // Delete all notification of this user
            Notifications::where('from_id', '=', $user->id)->delete();
            Notifications::where('user_id', '=', $user->id)->delete();
            // Delete all favorites of this user
            $user->votes()->delete();
            // Delete all followers of this user
            $user->followers()->delete();
            // Delete all following of thi user
            $user->following()->delete();
            // Delete user itself
            $user->delete();

            return Redirect::to('admin/users')->with('flashSuccess', 'User is now deleted');
        }
        $user->fullname = Input::get('fullname');
        $user->email = Input::get('email');
        $user->blogurl = Input::get('blogurl');
        if (Input::get('featured') == 'TRUE')
        {
            if ( ! $user->featured_at)
                $user->featured_at = Carbon::now();
        }
        else
        {
            $user->featured_at = null;
        }

        if (Input::get('confirmed') == '1')
        {
            $user->confirmed = '1';
        }

        // User Ban settings
        $user->permission = null;

        if (Input::get('ban'))
        {
            $user->permission = 'ban';
        }
        if (Input::get('make_admin'))
        {
            $user->permission = 'admin';
        }

        if (Input::get('fb_link'))
        {
            $user->fb_link = Input::get('fb_link');
        }
        if (Input::get('tw_link'))
        {
            $user->tw_link = Input::get('tw_link');
        }
        $user->save();

        return Redirect::back()->with('flashSuccess', 'User "' . $user->username . '" is updated');
    }


    /**
     * Add new user post request
     *
     * @return mixed
     */
    public function addUser()
    {
        $v = [
            'username' => ['required', 'unique:users', 'alpha_num'],
            'email'    => ['required', 'unique:users'],
            'fullname' => ['required'],
            'password' => ['required'],
        ];
        $v = Validator::make(Input::all(), $v);
        if ($v->fails())
        {
            return Redirect::to('admin/adduser')->withErrors($v);
        }
        $user = new User();
        $user->username = Input::get('username');
        $user->fullname = Input::get('fullname');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->confirmed = 1;
        $user->save();

        return Redirect::to('admin')->with('flashSuccess', 'New user is created');
    }
}