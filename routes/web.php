<?php

use App\Core\Router;

$router = new Router();

$router->get("/", "HomeController@index");
$router->get("/blog/{id}", "BlogController@show");

$router->match();