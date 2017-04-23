<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Repository\PostsRepositoryInterface;
use Mediavenue\Validator\PostsValidator;

class LinksController extends BaseController {

    public function __construct(PostsRepositoryInterface $post, PostsValidator $validator)
    {
        $this->validator = $validator;
        $this->post = $post;
    }

    public function getSubmit()
    {
        return View::make('links/submit');
    }

    public function create()
    {
        if ( ! $this->validator->validLinksCreate(Input::all()))
            return Redirect::back()->withErrors($this->validator->errors())->withInput();

        $post = $this->post->create(Input::all(), null, 'link');

        if ((bool) autoApprove() == false)
        {
            return Redirect::route('home')->with('flashSuccess', t('We will review your post shortly, please keep patience'));
        }

        return Redirect::route('post', ['id' => $post->id, 'slug' => $post->slug]);
    }
}