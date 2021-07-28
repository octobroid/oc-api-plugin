<?php namespace Octobro\API;

use App;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {
        // Register Cors
        App::register('\Barryvdh\Cors\ServiceProvider');

        // Add cors middleware
        $this->app['Illuminate\Contracts\Http\Kernel']
            ->prependMiddleware(\Barryvdh\Cors\HandleCors::class);

    }

    public function register()
    {
        $this->registerConsoleCommand('octobro.api.transformer', 'Octobro\API\Console\CreateTransformer');
    }
}
