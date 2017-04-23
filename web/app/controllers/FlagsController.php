<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Repository\FlagsRepositoryInterface;
use Mediavenue\Repository\PostsRepositoryInterface;
use Mediavenue\Repository\UsersRepositoryInterface;
use Mediavenue\Validator\FlagsValidator;

class FlagsController extends BaseController {

    /**
     * @var Mediavenue\Repository\FlagsRepositoryInterface
     */
    private $flags;
    /**
     * @var Mediavenue\Repository\PostsRepositoryInterface
     */
    private $posts;
    /**
     * @var Mediavenue\Validator\FlagsValidator
     */
    private $validator;
    /**
     * @var Mediavenue\Repository\UsersRepositoryInterface
     */
    private $user;

    /**
     * @param PostsRepositoryInterface                       $posts
     * @param FlagsValidator                                 $validator
     * @param FlagsRepositoryInterface                       $flags
     * @param Mediavenue\Repository\UsersRepositoryInterface $user
     */
    public function __construct(PostsRepositoryInterface $posts, FlagsValidator $validator, FlagsRepositoryInterface $flags, UsersRepositoryInterface $user)
    {
        $this->flags = $flags;
        $this->posts = $posts;
        $this->validator = $validator;
        $this->user = $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getIndex($id)
    {
        $post = $this->posts->getById($id);
        if ( ! $post)
            return Redirect::route('home')->with('flashError', t('Nothing found'));

        return View::make('flag/index');
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getUserIndex($username)
    {
        $post = $this->user->getByUsername($username);
        if ( ! $post)
            return Redirect::route('home')->with('flashError', t('Nothing found'));

        return View::make('flag/index');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function postReport($id)
    {
        $post = $this->posts->getById($id);

        if ( ! $post)
            return Redirect::route('home')->with('flashError', t('Nothing found'));

        if ( ! $this->validator->validCreate(Input::all()))
            return Redirect::back()->withInput()->withErrors($this->validator->errors());

        $this->flags->report($post, Input::get('reason'));

        return Redirect::route('home')->with('flashSuccess', t('Reported is submitted, please keep patience'));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function postUserReport($username)
    {
        $user = $this->user->getByUsername($username);

        if ( ! $user)
            return Redirect::route('home')->with('flashError', t('Nothing found'));

        if ( ! $this->validator->validCreate(Input::all()))
            return Redirect::back()->withInput()->withErrors($this->validator->errors());

        $this->flags->reportUser($user, Input::get('reason'));

        return Redirect::route('home')->with('flashSuccess', t('Reported is submitted, please keep patience'));
    }
}