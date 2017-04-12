<?php

    Route::group([
        'prefix' => 'api/v1',
        'namespace' => 'Octobro\API\Controllers',
        'middleware' => 'cors'
        ], function() {
            Route::post('auth/access_token', 'Auth@accessToken');
            Route::post('auth/register', 'Auth@register');
            Route::post('auth/forgot', 'Auth@forgot');

            Route::group(['middleware' => 'oauth'], function() {
                //
            });
    });

?>