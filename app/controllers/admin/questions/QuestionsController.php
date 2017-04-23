<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Controllers\Admin\Questions;

use Input;
use Mediavenue\Repository\PostsRepositoryInterface;
use Mediavenue\Validator\QuestionsValidator;
use Purifier;
use Redirect;
use Str;
use View;

class QuestionsController extends \BaseController {

    public function __construct(PostsRepositoryInterface $posts, QuestionsValidator $validator)
    {
        $this->posts = $posts;
        $this->validator = $validator;
    }

    public function getAll()
    {
        $posts = $this->posts->getLatest('question', Input::get('category'), 'asc');
        $title = 'List Of Questions';

        return View::make('admin/posts/list', compact('posts', 'title'));
    }

    public function getEdit($id)
    {
        $post = $this->posts->getByIdForAdmin($id);
        if ( ! $post)
        {
            return Redirect::to('admin/question')->with('flashError', 'Nothing found');
        }

        return View::make('admin/posts/edit', compact('post'));
    }

    public function getFeatured()
    {
        $posts = $this->posts->getFeatured('question', Input::get('category'));
        $title = 'Featured Questions';

        return View::make('admin/posts/list', compact('posts', 'title'));
    }

    public function getApprovalRequired()
    {
        $posts = $this->posts->getApprovalRequired('question', Input::get('category'));
        $title = 'Required Approval';

        return View::make('admin/posts/list', compact('posts', 'title'));
    }

    public function update($id)
    {
        if ( ! $this->validator->validAdminEdit(Input::all())) return Redirect::back()->withInput()->withErrors($this->validator->errors());

        $post = $this->posts->getByIdForAdmin($id);
        $post = $this->posts->adminEdit($post, Input::all());
        if (Input::get('delete'))
        {
            return Redirect::to('admin/questions')->with('flashSuccess', 'Post is now deleted');
        }

        return Redirect::back()->with('flashSuccess', 'Updated');
    }
}