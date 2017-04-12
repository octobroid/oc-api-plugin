<?php namespace Octobro\API;

use App;
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
        App::register('\LucaDegasperi\OAuth2Server\Storage\FluentStorageServiceProvider');
        App::register('\LucaDegasperi\OAuth2Server\OAuth2ServerServiceProvider');

        // Add alias
        $alias = AliasLoader::getInstance();
        $alias->alias('Authorizer', '\LucaDegasperi\OAuth2Server\Facades\Authorizer');

        // Add oauth middleware
        // $this->middleware(\LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware::class);

        // Add oauth route middleware
        $this->app['router']->middleware('oauth', \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class);
        $this->app['router']->middleware('oauth-user', \LucaDegasperi\OAuth2Server\Middleware\OAuthUserOwnerMiddleware::class);
        $this->app['router']->middleware('oauth-client', \LucaDegasperi\OAuth2Server\Middleware\OAuthClientOwnerMiddleware::class);
        $this->app['router']->middleware('check-authorization-params', \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class);

        // Handle error
        App::error(function(\Exception $e) {
            $trace = $e->getTraceAsString();

            // Not sure it's the right way to do...
            if (\mb_strpos($trace, 'Octobro\API\Controllers') || \mb_strpos($trace, 'LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware')) {
                return [
                    'error' => [
                        'code' => 'INTERNAL_ERROR',
                        'http_code' => 500,
                        'message' => $e->getMessage(),
                    ]
                ];
            }
        });
    }
}
