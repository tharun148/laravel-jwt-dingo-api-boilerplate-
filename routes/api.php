<?php

use Illuminate\Http\Request;
use Dingo\Api\Routing\Router;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function (Router $api) {
        $api->post('login', 'App\Http\Controllers\UserController@login');
        $api->post('signup', 'App\Http\Controllers\UserController@signup');
        $api->post('recovery', 'App\Http\Controllers\UserController@sendResetEmail');
        $api->post('reset', 'App\Http\Controllers\UserController@resetPassword');
        $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
            $api->post('logout', 'App\Http\Controllers\UserController@logout');
            $api->post('refresh', 'App\Http\Controllers\UserController@refresh');
        });
    });
});