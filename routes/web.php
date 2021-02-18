<?php

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

use Illuminate\Http\Request;

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(["prefix"=> "auth"], function () use ($router) {
    $router->post("/register", "AuthController@register");
    $router->post("/login", ["uses" => "AuthController@authenticate"]);
});

/**
 * Routes for categories and there tickets
 */
$router->group(["middleware" => "auth","prefix" => "api/v1/categories"], function () use ($router) {
        $router->get("/", "CategoriesController@index");
        $router->post("/", "CategoriesController@store");
        $router->get("/{id}", "CategoriesController@show");
        $router->put("/{id}", "CategoriesController@update");
        $router->delete("/{id}", "CategoriesController@destroy");

        $router->post("/{id}/tickets", "TicketController@store");
        $router->get("/{id}/tickets", "TicketsController@index");
        $router->get("/{id}/tickets/{ticket_id}", "TicketsController@show");
        $router->put("/{id}/tickets/{ticket_id}", "TicketsController@update");
        $router->delete("/{id}/tickets/{ticket_id}", "TicketsController@destroy");
    }
);
