<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Repository\ReplyRepositoryInterface;

class ReplyController extends BaseController {

    /**
     * @var Mediavenue\Repository\ReplyRepositoryInterface
     */
    private $reply;

    /**
     * @param ReplyRepositoryInterface $reply
     */
    public function  __construct(ReplyRepositoryInterface $reply)
    {

        $this->reply = $reply;
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $reply = $this->reply->create(Input::all());

        if ( ! $reply)
        {
            return 'Not allowed';
        }

        return Response::json([
            'fullname'       => e(Auth::user()->fullname),
            'profile_link'   => Auth::user()->username,
            'profile_avatar' => get_gravatar(Auth::user()->email, 64),
            'description'    => e($reply->description),
            'time'           => $reply->created_at->diffForHumans(),
            'comment_id'     => $reply->comment_id,
            'reply'          => e($reply->description),
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        if (Auth::check() == false)
        {
            return '';
        }

        if ($this->reply->delete(Input::get('id')))
        {
            return 'success';
        }

        return 'false';
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

        if ( ! $reply = $this->reply->getById($id))
        {
            return Response::make('error', 404);
        }

        if ( ! $voted = $reply->votes()->whereUserId(Auth::user()->id)->first())
        {
            $this->reply->vote($id);
        }
        else
        {
            $this->reply->deleteVote($id);
        }

        return Response::make($reply->votes()->count(), 200);
    }
}