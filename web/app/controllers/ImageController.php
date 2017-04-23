<?php
use Mediavenue\Repository\PostsRepositoryInterface;
use Mediavenue\Validator\PostsValidator;

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class ImageController extends BaseController {

    public function  __construct(PostsRepositoryInterface $post, PostsValidator $validator)
    {
        $this->post = $post;
        $this->validator = $validator;
    }

    public function index()
    {
        $title = t('Submitting Image');

        return View::make('image/submit', compact('title'));
    }

    public function create()
    {
        if ( ! $this->validator->validImageUpload(Input::all()))
            return Redirect::back()->withErrors($this->validator->errors());

        $extension = Input::file('image')->getClientOriginalExtension();
        $name = $this->dirName() . '.' . $extension;
        Input::file('image')->move(public_path() . '/uploads/', $name);
        $post = $this->post->create(Input::only(['title', 'summary', 'category']), $name, 'image');

        if ((bool) autoApprove() == false)
        {
            return Redirect::route('home')->with('flashSuccess', t('We will review your post shortly, please keep patience'));
        }

        return Redirect::route('post', ['id' => $post->id, 'slug' => $post->slug]);
    }

    private function dirName()
    {
        $str = str_random(9);
        if (file_exists(public_path() . '/uploads/' . $str))
        {
            $str = $this->dirName();
        }

        return $str;
    }
}