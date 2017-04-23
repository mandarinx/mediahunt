<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Repository\PostsRepositoryInterface;
use Mediavenue\Repository\VotesRepositoryInterface;
use Mediavenue\Validator\PostsValidator;

class PostsController extends BaseController {

    public function __construct(PostsRepositoryInterface $post, PostsValidator $validator, VotesRepositoryInterface $votes)
    {
        $this->post = $post;
        $this->validator = $validator;
        $this->votes = $votes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('post/submitInitial');
    }


    public function stepTow()
    {
        $title = Session::get('post_information')['title'];
        $url = Session::get('post_information')['url'];

        return View::make('post/submit')->with('title', $title)->with('url', $url);
    }

    public function postInitial()
    {
        if ( ! $this->validator->validCreateInitial(Input::all()))
        {
            return Redirect::back()->withInput()->withErrors($this->validator->errors());
        }
        $post = Embedder::initialize(Input::get('url'));
        if ( ! $post->validate())
        {
            return Redirect::back()->withInput()->withErrors('Submitted link is not allowed or valid');
        }
        $postInformation = [
            'title' => $post->title(),
            'url'   => formatUrl(Input::get('url')),
        ];
        Session::put('post_information', $postInformation);

        return Redirect::route('post-steptow')->with(compact('title', 'url'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ( ! $this->validator->validCreate(Input::all()))
        {
            return Redirect::back()->withInput()->withErrors($this->validator->errors());
        }
        $post = Embedder::initialize(Input::get('url'));
        if ( ! $post->validate())
        {
            return Redirect::back()->withInput()->withErrors('Submitted link is not allowed or valid');
        }
        $post = $this->post->create(Input::all(), $post);

        if ((bool) autoApprove() == false)
        {
            return Redirect::route('home')->with('flashSuccess', t('We will review your post shortly, please keep patience'));
        }

        return Redirect::route('post', ['id' => $post->id, 'slug' => $post->slug]);
    }


    public function show($id, $slug = null)
    {
        $post = $this->post->getById($id);
        if ( ! $post || ! $post->approved_at)
        {
            return Redirect::route('trending')->with('flashError', t('Nothing Found'));
        }
        if ($slug != $post->slug)
        {
            return Redirect::route('post', ['id' => $post->id, 'slug' => $post->slug]);
        }
        Event::fire('posts.views', $post);
        $comments = $post->comments()->with('user', 'reply', 'reply.user', 'reply.comment')->orderBy('created_at', 'desc')->paginate(perPage());
        $title = t('Posts');

        $next = $this->post->findNextPost($post);
        $previous = $this->post->findPreviousPost($post);
        $related = $this->post->findRelatedPosts($post);

        return View::make('post/post', compact('post', 'comments', 'title', 'next', 'previous', 'related'));
    }


    public function getTrending()
    {
        $posts = $this->post->getTrending(Input::get('provider'), Input::get('category'));
        $title = t('Trending Posts');

        return View::make('post.list', compact('posts', 'title'));
    }

    public function getLatest()
    {
        $posts = $this->post->getLatest(Input::get('provider'), Input::get('category'));
        $title = t('Latest Posts');

        return View::make('post.list', compact('posts', 'title'));
    }

    public function getFeatured()
    {
        $posts = $this->post->getFeatured(Input::get('provider'), Input::get('category'));
        $title = t('Featured Posts');

        return View::make('post.list', compact('posts', 'title'));
    }

    public function vote()
    {
        $id = Input::get('id');

        if ( ! $id)
        {
            return Response::make('error', 404);
        }

        $post = $this->post->getAnyById($id);

        if ( ! $post)
        {
            return Response::make('error', 404);
        }

        $voted = $post->votes()->whereUserId(Auth::user()->id)->first();
        if ( ! $voted)
        {
            $this->votes->vote($post);
        }
        else
        {
            $voted->delete();
        }

        return Response::make($post->votes()->count(), 200);
    }

    public function edit($id)
    {
        $post = $this->post->getById($id);
        $title = 'Editing';
        if ( ! $post || $post->user->id !== Auth::user()->id)
        {
            return Redirect::route('home')->with('flashError', t('Nothing Found'));
        }

        return View::make('post/edit', compact('post', 'title'));
    }

    public function postEdit($id)
    {
        $post = $this->post->getById($id);

        if ( ! $this->validator->validEdit(Input::all()))
        {
            return Redirect::back()->withInput()->withErrors($this->validator->errors());
        }

        $post = $this->post->edit($post, Input::all());
        if (Input::get('delete'))
        {
            return Redirect::route('home')->with('flashSuccess', t('Post is now deleted'));
        }

        return Redirect::route('post', ['id' => $post->id, 'slug' => $post->slug])->with('flashSuccess', t('Post is now update'));
    }
}
