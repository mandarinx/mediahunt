<?php namespace Mediavenue\Embedder;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class EmbedderServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['embedder'] = $this->app->share(function ($app)
        {
            return new Embedder();
        });
    }

    public function boot()
    {
        $this->package('abhimanyusharma003/conversion');
        $this->app->booting(function ()
        {
            $loader = AliasLoader::getInstance();
            $loader->alias('Embedder', 'Mediavenue\Embedder\EmbedderFacade');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['embedder'];
    }

}