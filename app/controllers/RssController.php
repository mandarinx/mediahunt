<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Repository\PostsRepositoryInterface;

class RssController extends BaseController {

    public function __construct(PostsRepositoryInterface $posts)
    {
        $this->posts = $posts;
    }

    public function getRss()
    {
        if (Input::get('type') === 'questions' || Input::get('type') === 'news')
        {
            switch (Input::get('only'))
            {
                case 'latest':
                    $posts = $this->posts->getLatest(Input::get('type'), Input::get('category'));
                    break;
                case 'trending':
                    $posts = $this->posts->getTrending(Input::get('type'), Input::get('category'));
                    break;
                case 'featured':
                    $posts = $this->posts->getFeatured(Input::get('type'), Input::get('category'));
                    break;
                default:
                    $posts = $this->posts->getLatest(Input::get('type'), Input::get('category'));
            }

            return $this->generateRss($posts);
        }

        return $this->generateRss($this->posts->getTrending());

    }


    public function generateRss($posts)
    {
        $feed = Feed::make();
        $feed->title = siteSettings('siteName');
        $feed->description = siteSettings('siteName');
        $feed->lang = 'en';

        foreach ($posts as $post)
        {
            $desc = '<h2><a href="' . route('post', ['id' => $post->id, 'slug' => $post->slug]) . '">' . e($post->title) . '</a>
                by
                <a href="' . route('user', ['username' => $post->user->username]) . '">' . ucfirst($post->user->fullname) . '</a>
                ( <a href="' . route('user', ['username' => $post->user->username]) . '">' . $post->user->username . '</a> )
                </h2>' . $post->summary;
            $feed->add(ucfirst($post->title), $post->user->fullname, route('post', ['id' => $post->id, 'slug' => $post->slug]), $post->created_at, $desc);
        }

        return $feed->render('atom');
    }

}