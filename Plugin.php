<?php namespace Octobro\API;

use App;
use Config;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase
{
    public function boot()
    {
        // Register Cors
        App::register('\Barryvdh\Cors\ServiceProvider');

        // Add cors middleware
        app('router')->aliasMiddleware('cors', \Barryvdh\Cors\HandleCors::class);

        // Handle error
        App::error(function(\Exception $e) {
            header("Access-Control-Allow-Origin: *");
            $trace = $e->getTraceAsString();

            // Not sure it's the right way to do...
            if (\mb_strpos($trace, 'Octobro\API\Controllers')) {
                $error = [
                    'error' => [
                        'code' => 'INTERNAL_ERROR',
                        'http_code' => 500,
                        'message' => $e->getMessage(),
                    ],
                ];

                if (Config::get('app.debug'))
                    $error['trace'] = $e->getTrace();

                return $error;
            }
        });
    }
}
