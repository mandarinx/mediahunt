<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Mediavenue\Repository\PostsRepositoryInterface;

class SearchController extends BaseController {

    public function __construct(PostsRepositoryInterface $posts)
    {
        $this->posts = $posts;
    }

    public function search()
    {
        $posts = $this->posts->search(Input::get('q'));
        $title = t('Search Results');

        return View::make('post/list', compact('posts', 'title'));
    }
}