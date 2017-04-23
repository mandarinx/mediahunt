<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Controllers\Admin\Comments;

use Auth;
use Cache;
use Comment;
use DB;
use File;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Request;
use Str;
use View;

class CommentsController extends \BaseController {

    public function getComments()
    {
        $comments = Comment::orderBy('created_at', 'desc')->with('post', 'user')->paginate(50);
        $title = 'Latest Comments';

        return View::make('admin/comments/comments', compact('comments', 'title'));
    }

    public function getEditComment($id)
    {
        $comment = Comment::where('id', '=', $id)->first();
        if ($comment)
            return View::make('admin/comments/edit')->with('title', 'Editing Comment')->with('comment', $comment);
        else
            return Redirect::back()->with('flashError', 'No comment found');
    }

    public function postEditComment($id)
    {
        $comment = Comment::where('id', '=', $id)->first();
        $v = [
            'description' => ['required'],
        ];
        $v = Validator::make(Input::all(), $v);
        if ($v->fails())
            return Redirect::back()->with('title', 'Editing Comment')->withErrors($v);
        $delete = Input::get('delete');
        if ($delete)
        {
            foreach ($comment->reply as $reply)
                $reply->delete();
            $comment->delete();

            return Redirect::to('admin/comments')->with('title', 'Editing Comment')->with('flashSuccess', 'Comment is now deleted');
        }
        $comment->description = Input::get('description');
        $comment->save();

        return Redirect::back()->with('title', 'Editing Comment')->with('flashSuccess', 'Comment is now updated');
    }
}