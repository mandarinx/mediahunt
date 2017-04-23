<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Repository\CommentsRepositoryInterface;
use Mediavenue\Validator\CommentsValidator;

class CommentsController extends BaseController {

    /**
     * @var Mediavenue\Repository\CommentsRepositoryInterface
     */
    private $comments;
    /**
     * @var Mediavenue\Validator\CommentsValidator
     */
    private $validator;


    /**
     * @param CommentsValidator                                 $validator
     * @param Mediavenue\Repository\CommentsRepositoryInterface $comment
     */
    public function __construct(CommentsValidator $validator, CommentsRepositoryInterface $comment)
    {
        $this->comment = $comment;
        $this->validator = $validator;
    }

    /**
     * @param      $id
     * @param null $slug
     * @return mixed
     */
    public function create($id, $slug = null)
    {
        if ( ! $id || ! $slug)
        {
            return Redirect::back()->with('flashError', t('Please try again'));
        }

        if ( ! $this->validator->validCreate(Input::all()))
        {
            return Redirect::back()->withErrors($this->validator->errors());
        }

        $this->comment->create($id, Input::all());

        return Redirect::back()->with('flashSuccess', t('Comment is posted'));
    }

    /**
     * @return string
     */
    public function delete()
    {
        if ( ! Auth::check())
        {
            return '';
        }

        if ($this->comment->delete(Input::get('id')))
        {
            return 'success';
        }

        return 'failed';
    }

    /**
     * @return mixed
     */
    public function vote()
    {
        $id = Input::get('id');
        if (Auth::check() == false || ! $id)
        {
            return Response::make('error', 404);
        }

        if ( ! $comment = $this->comment->getById($id))
        {
            return Response::make('error', 404);
        }

        if ( ! $voted = $comment->votes()->whereUserId(Auth::user()->id)->first())
        {
            $this->comment->vote($id);
        }
        else
        {
            $this->comment->deleteVote($id);
        }

        return Response::make($comment->votes()->count(), 200);
    }
}