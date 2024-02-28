<?php namespace Octobro\API;

use App;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {
        // Add cors middleware
        $this->app['Illuminate\Contracts\Http\Kernel']
            ->prependMiddleware(\Illuminate\Http\Middleware\HandleCors::class);

    }

    public function register()
    {
        $this->registerConsoleCommand('octobro.api.transformer', 'Octobro\API\Console\CreateTransformer');
    }
}
