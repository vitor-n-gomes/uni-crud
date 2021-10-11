<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');

    $router->post('employee', 'EmployeeController@register');
    $router->put('employee/{id}', 'EmployeeController@update');

    $router->post('todo', 'TodoController@register');
    $router->put('todo/{id}', 'TodoController@update');
    $router->put('todo/{id}/status', 'TodoController@status');
    
    $router->get('timeline/{id}', 'TodoController@myDay');
    $router->get('mytask/{id}', 'TodoController@myTask');

});
