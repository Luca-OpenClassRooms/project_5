<?php

namespace App\Core;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

use Symfony\Component\HttpFoundation\Request;

class Router 
{
    private $routes;
    private $context;
    private $request;
    
    public function __construct()
    {
        $this->request = Request::createFromGlobals();

        $context = new RequestContext();
        $context->fromRequest($this->request);

        $this->routes = new RouteCollection();
        $this->context = $context;
    }

    public function get($uri, $controller)
    {
        $route = new Route($uri, [
            "_controller" => $controller
        ]);
        $route->setMethods(["GET"]);

        return $this->routes->add($uri, $route);
    }

    public function post($uri, $controller)
    {
        $route = new Route($uri, [
            "_controller" => $controller
        ]);
        $route->setMethods(["POST"]);

        return $this->routes->add($uri, $route);
    }

    public function match()
    {
        $context = $this->context;
        $matcher = new UrlMatcher($this->routes, $context);
        $parameters = $matcher->match($context->getPathInfo());

        $controller = explode("@", $parameters["_controller"]);

        $className = "App\Controllers\\" . $controller[0];
        $methodName = $controller[1];

        if( !class_exists($className) )
            return die("Controller not found.");
        
        $class = new $className();

        if( !method_exists($class, $methodName) )
            return die("Method controller not found.");

        echo call_user_func_array([$class, $methodName], [
            $this->request
        ]);
    }
}