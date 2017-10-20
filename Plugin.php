<?php namespace Octobro\API;

use App;
use Config;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot()
    {
        // Register Cors
        App::register('\Barryvdh\Cors\ServiceProvider');

        // Register oAuth
        App::register('\Octobro\API\Storage\FluentStorageServiceProvider');
        App::register('\Octobro\API\Classes\OAuth2ServerServiceProvider');

        // Add alias
        $alias = AliasLoader::getInstance();
        $alias->alias('Authorizer', '\Octobro\API\Facades\Authorizer');

        // Add cors middleware
        app('router')->aliasMiddleware('cors', \Barryvdh\Cors\HandleCors::class);

        // Add oauth middleware
        // $this->middleware(\Octobro\API\Middleware\OAuthExceptionHandlerMiddleware::class);

        // Add oauth route middleware
        app('router')->aliasMiddleware('oauth' , \Octobro\API\Middleware\OAuthMiddleware::class);
        app('router')->aliasMiddleware('oauth-user' , \Octobro\API\Middleware\OAuthUserOwnerMiddleware::class);
        app('router')->aliasMiddleware('oauth-client' , \Octobro\API\Middleware\OAuthClientOwnerMiddleware::class);
        app('router')->aliasMiddleware('check-authorization-params', \Octobro\API\Middleware\CheckAuthCodeRequestMiddleware::class);

        // Handle error
        App::error(function(\Exception $e) {
            header("Access-Control-Allow-Origin: *");
            $trace = $e->getTraceAsString();

            // Not sure it's the right way to do...
            if (\mb_strpos($trace, 'Octobro\API\Controllers') || \mb_strpos($trace, 'Octobro\API\Middleware\OAuthMiddleware')) {
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
