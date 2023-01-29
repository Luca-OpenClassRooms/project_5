<?php

$app = \App\Core\App::getInstance();

$router = $app->get("router");

$router->get("/", "HomeController@index", "index");
$router->get("/blog/{slug}", "PostController@show", "blog.show");

$router->get("/auth/login", "Auth\LoginController@index", "auth.login");
$router->post("/auth/login", "Auth\LoginController@authentificate", "auth.authentificate");
$router->post("/auth/logout", "Auth\LoginController@logout", "auth.logout");

$router->get("/seed", "SeederController@index", "seed.index");

$router->get("/dashboard", "Dashboard\IndexController@index", "dashboard.index");
$router->get("/dashboard/posts", "Dashboard\PostController@index", "dashboard.posts.index");

$router->get("/dashboard/posts/create", "Dashboard\PostController@create", "dashboard.posts.create");
$router->post("/dashboard/posts", "Dashboard\PostController@store", "dashboard.posts.store");

$router->get("/dashboard/posts/{id}/edit", "Dashboard\PostController@edit", "dashboard.posts.edit");
$router->post("/dashboard/posts/{id}", "Dashboard\PostController@update", "dashboard.posts.update");