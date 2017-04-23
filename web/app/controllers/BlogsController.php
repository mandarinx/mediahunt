<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

use Mediavenue\Repository\PostsRepositoryInterface;
use Mediavenue\Validator\PostsValidator;

class BlogsController extends BaseController {

    /**
     * @param PostsRepositoryInterface $post
     * @param PostsValidator           $validator
     */
    public function __construct(PostsRepositoryInterface $post, PostsValidator $validator)
    {
        $this->post = $post;
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function getSubmit()
    {
        $title = t('Submitting Blog');

        return View::make('blogs/submit', compact('title'));
    }

    /**
     * @return mixed
     */
    public function create()
    {
        if ( ! $this->validator->validBlogCreate(Input::all()))
            return Redirect::back()->withErrors($this->validator->errors());
        $post = $this->post->create(Input::all(), null, 'blog');

        if ((bool) autoApprove() == false)
        {
            return Redirect::route('home')->with('flashSuccess', t('We will review your post shortly, please keep patience'));
        }

        return Redirect::route('post', ['id' => $post->id, 'slug' => $post->slug]);
    }
}