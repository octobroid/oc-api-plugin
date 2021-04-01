<?php namespace Octobro\API;

use App;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {
        // Register Cors
        App::register('\Fruitcake\Cors\CorsServiceProvider');

        // Add cors middleware
        app('router')->aliasMiddleware('cors', \Fruitcake\Cors\HandleCors::class);
        
    }

    public function register()
    {
        $this->registerConsoleCommand('octobro.api.transformer', 'Octobro\API\Console\CreateTransformer');
    }
}
