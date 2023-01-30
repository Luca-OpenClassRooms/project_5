<?php

$app = \App\Core\App::getInstance();

$router = $app->get("router");

$router->get("/", "HomeController@index", "index");

$router->get("/posts/{slug}", "PostController@show", "posts.show");
$router->post("/posts/{slug}/comments", "PostCommentController@store", "comments.store");

$router->group([
    "prefix" => "comments",
    "as" => "comments.",
    "middleware" => ["admin"]
], function($router){
    $router->post("/{id}", "PostCommentController@update", "update");
    $router->post("/{id}/delete", "PostCommentController@destroy", "destroy");
});

$router->group(["prefix" => "auth", "as" => "auth."], function($router){
    $router->group(["middleware" => ["guest"]], function($router){
        $router->get("/login", "Auth\LoginController@index", "login");
        $router->post("/login", "Auth\LoginController@authentificate", "authentificate");

        $router->get("/register", "Auth\RegisterController@index", "register");
        $router->post("/register", "Auth\RegisterController@store", "register.store");
    });
    
    $router->group(["middleware" => ["auth"]], function($router){
        $router->post("/logout", "Auth\LoginController@logout", "logout");
    });
});

$router->get("/seed", "SeederController@index", "seed.index");

$router->group([
    "prefix" => "dashboard", 
    "as" => "dashboard.",
    "middleware" => ["admin"]
], function($router){
    $router->get("", "Dashboard\IndexController@index", "index");
    $router->get("/posts", "Dashboard\PostController@index", "posts.index");
    
    $router->get("/posts/create", "Dashboard\PostController@create", "posts.create");
    $router->post("/posts", "Dashboard\PostController@store", "posts.store");

    $router->get("/posts/{id}/edit", "Dashboard\PostController@edit", "posts.edit");
    $router->post("/posts/{id}", "Dashboard\PostController@update", "posts.update");
    $router->post("/posts/{id}/delete", "Dashboard\PostController@destroy", "posts.destroy");
});