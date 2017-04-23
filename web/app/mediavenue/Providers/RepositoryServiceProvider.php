<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Mediavenue\Repository\PostsRepositoryInterface',
            'Mediavenue\Repository\Eloquent\PostsRepository'
        );

        $this->app->bind(
            'Mediavenue\Repository\UsersRepositoryInterface',
            'Mediavenue\Repository\Eloquent\UsersRepository'
        );

        $this->app->bind(
            'Mediavenue\Repository\BlogsRepositoryInterface',
            'Mediavenue\Repository\Eloquent\BlogsRepository'
        );

        $this->app->bind(
            'Mediavenue\Repository\FlagsRepositoryInterface',
            'Mediavenue\Repository\Eloquent\FlagsRepository'
        );

        $this->app->bind(
            'Mediavenue\Repository\CommentsRepositoryInterface',
            'Mediavenue\Repository\Eloquent\CommentsRepository'
        );

        $this->app->bind(
            'Mediavenue\Repository\ReplyRepositoryInterface',
            'Mediavenue\Repository\Eloquent\ReplyRepository'
        );

        $this->app->bind(
            'Mediavenue\Repository\VotesRepositoryInterface',
            'Mediavenue\Repository\Eloquent\VotesRepository'
        );

        $this->app->bind(
            'Mediavenue\Repository\FollowRepositoryInterface',
            'Mediavenue\Repository\Eloquent\FollowRepository'
        );
    }
}