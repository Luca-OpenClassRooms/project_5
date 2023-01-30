<?php

$app = \App\Core\App::getInstance();

$router = $app->get("router");

$router->get("/", "HomeController@index", "index");

$router->get("/posts/{slug}", "PostController@show", "posts.show");

$router->post("/posts/{slug}/comments", "PostCommentController@store", "comments.store");
$router->post("/comments/{id}", "PostCommentController@update", "comments.update");
$router->post("/comments/{id}/delete", "PostCommentController@destroy", "comments.destroy");

$router->get("/auth/login", "Auth\LoginController@index", "auth.login");
$router->post("/auth/login", "Auth\LoginController@authentificate", "auth.authentificate");
$router->post("/auth/logout", "Auth\LoginController@logout", "auth.logout");

$router->get("/seed", "SeederController@index", "seed.index");

$router->group([
    "prefix" => "dashboard", 
    "as" => "dashboard.",
    "middleware" => ["auth"]
], function($router){
    $router->get("", "Dashboard\IndexController@index", "index");
    $router->get("/posts", "Dashboard\PostController@index", "posts.index");
    
    $router->get("/posts/create", "Dashboard\PostController@create", "posts.create");
    $router->post("/posts", "Dashboard\PostController@store", "posts.store");

    $router->get("/posts/{id}/edit", "Dashboard\PostController@edit", "posts.edit");
    $router->post("/posts/{id}", "Dashboard\PostController@update", "posts.update");
    $router->post("/posts/{id}/delete", "Dashboard\PostController@destroy", "posts.destroy");
});