<?php namespace Mediavenue\Embedder;

use Illuminate\Support\Facades\Facade;

class EmbedderFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'embedder';
    }

}