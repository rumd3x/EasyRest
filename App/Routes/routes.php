<?php

use EasyRest\System\Routing\Route;
use EasyRest\System\Routing\RouteGroup;
use EasyRest\App\Middlewares\TrimString;

new Route(Route::GET, '/', 'MainController@index');
new Route(Route::GET, '/home', 'MainController@home', ['TrimString']);

new Route(Route::GET, '/probe', function () {
    echo 'ok';
});

new RouteGroup('/teste', [TrimString::class], [
    [Route::POST, '/:id:', 'MainController@teste'],
    [Route::GET, '/', function () {
        echo 'aeeee';
    }],
    [Route::GET, ':id:', function (int $id) {
        echo $id;
    }],
]);
