<?php

namespace Mediavenue\Events;

use Illuminate\Session\Store;
use Mediavenue\Repository\PostsRepositoryInterface;

class NewsViewHandler {

    /**
     * @param PostsRepositoryInterface $news
     * @param Store                    $session
     */
    public function __construct(PostsRepositoryInterface $news, Store $session)
    {
        $this->session = $session;
        $this->news = $news;
    }

    /**
     * @param $news
     */
    public function handle($news)
    {
        if ( ! $this->hasViewedTrick($news))
        {
            $news = $this->news->incrementViews($news);
            $this->storeViewedTrick($news);
        }
    }

    /**
     * @param $news
     * @return bool
     */
    protected function hasViewedTrick($news)
    {
        return array_key_exists($news->id, $this->getViewedTricks());
    }

    /**
     * Get the users viewed trick from the session.
     *
     * @return array
     */
    protected function getViewedTricks()
    {
        return $this->session->get('viewed_news', []);
    }

    /**
     * @param $news
     */
    protected function storeViewedTrick($news)
    {

        $key = 'viewed_news.' . $news->id;

        $this->session->put($key, time());
    }
}