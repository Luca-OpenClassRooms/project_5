<?php

$app = \App\Core\App::getInstance();

$router = $app->get("router");

$router->get("/", "HomeController@index", "index");
$router->get("/blog/{slug}", "BlogController@show", "blog.show");

$router->get("/auth/login", "Auth\LoginController@index", "auth.login");
$router->post("/auth/login", "Auth\LoginController@authentificate", "auth.authentificate");

$router->get("/seed", "SeederController@index", "seed.index");