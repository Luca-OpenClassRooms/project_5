<?php

namespace App\Core;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;

use function PHPSTORM_META\type;

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

    /**
     * Add a get route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller, string $name)
    {
        $route = new Route($uri, [
            "_controller" => $controller
        ]);
        $route->setMethods(["GET"]);

        return $this->routes->add($name, $route);
    }

    /**
     * Add a post route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller, string $name)
    {
        $route = new Route($uri, [
            "_controller" => $controller
        ]);
        $route->setMethods(["POST"]);

        return $this->routes->add($name, $route);
    }

    /**
     * Generate path for route name
     *
     * @param string $name
     * @param [type] ...$args
     * @return void
     */
    public function url(string $name, $params = [])
    {
        $generator = new UrlGenerator($this->routes, $this->context);
        $route = $this->routes->get($name);
        
        if( gettype($params) !== "array" ){
            $compiledRoute = $route->compile();
            $variables = $compiledRoute->getVariables();
            
            $firstParams = array_values($variables)[0];

            $newParams = [];
            $newParams[$firstParams] = $params;

            $params = $newParams;
        }
        
        return $generator->generate($name, $params);
    }

    /**
     * Run the module
     *
     * @return void
     */
    public function run()
    {
        // Load routes
        include_once "../routes/web.php";

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


        $args = [
            $this->request,
            ...array_filter($parameters, function($v, $k){
                return $k[0] != "_";
            }, ARRAY_FILTER_USE_BOTH)
        ];

        echo call_user_func_array([$class, $methodName], $args);
    }
}