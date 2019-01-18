<?php

use EasyRest\System\Routing\Route;

new Route(Route::GET, '/', 'MainController@index');
new Route(Route::GET, '/home', 'MainController@home');

new Route(Route::GET, '/probe', function () {
    echo 'ok';
});
