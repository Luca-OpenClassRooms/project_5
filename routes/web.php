<?php

$app = \App\Core\App::getInstance();

$router = $app->get("router");

$router->get("/", "HomeController@index");
$router->get("/blog/{id}", "BlogController@show");