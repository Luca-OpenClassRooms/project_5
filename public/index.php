<?php

if( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

// Load libraries
include_once "../vendor/autoload.php";

// Load environements variables
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

// Load App
$app = \App\Core\App::getInstance();

$app->register("config", \App\Core\Config::class);
$app->register("database", \App\Core\Database::class);
$app->register("router", \App\Core\Router::class);
$app->register("alert", \App\Core\Alert::class);

include_once "../app/functions.php";

echo $app->run();