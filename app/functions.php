<?php

use App\Core\App;

if( !function_exists("env") ){
    function env(string $name, string $default = null)
    {
        if( isset($_ENV[$name]) && !empty($_ENV[$name]) ){
            return $_ENV[$name];
        }

        return $default;
    }
}

if( !function_exists("dd") ){
    function dd(...$args)
    {
        echo "<pre>";
        var_dump(...$args);
        echo "</pre>";
        exit();
    }
}

if( !function_exists("config") ){
    function config(string $name = null)
    {
        $app = App::getInstance();
        $instance = $app->get("config");

        if( isset($name) ){
            return $instance->get($name);
        }

        return $instance;
    }
}