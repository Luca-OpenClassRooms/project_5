<?php

use App\Core\Router;

$router = new Router();

$router->get("/", "HomeController@index");
$router->get("/blog", "BlogController@index");

$router->match();