<?php

use App\Core\App;

if( !function_exists("app") ){
    function app(?string $module)
    {
        $instance = App::getInstance();

        if( $module )
            $instance = $instance->get($module);

        return $instance;
    }
}

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
        exit(1);
    }
}

if( !function_exists("config") ){
    function config(string $name = null)
    {
        $instance = app("config");

        if( isset($name) ){
            return $instance->get($name);
        }

        return $instance;
    }
}

if( !function_exists("alert") ){
    function alert(string $type, string $content)
    {
        $instance = app("alert");
        $instance->add($type, $content);
    }
}

if( !function_exists("back") ){
    function back()
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit(0);
    }
}

if( !function_exists("route") ){
    function route(string $name, ...$args)
    {
        $instance = app("router");
        return $instance->url($name, ...$args);
    }
}

if( !function_exists("redirect") ){
    function redirect(...$args)
    {
        header("Location: " . route(...$args));
        exit(0);
    }
}