<?php

namespace App\Core;

class App 
{

    /**
     * Instance of the application
     *
     * @var App
     */
    protected static $_instance;

    /**
     * Registered modules
     *
     * @var array
     */
    private $modules = [];

    /**
     * Get instance of the application
     *
     * @return App
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Register a new module
     *
     * @param string $name
     * @param [type] $module
     * @return void
     */
    public function register(string $name, $module)
    {
        $this->modules[$name] = new $module($this);
    }

    /**
     * Get instance of a module
     *
     * @param string $name
     * @return void
     */
    public function get(string $name)
    {
        return $this->modules[$name];
    }

    /**
     * Run the application
     *
     * @return void
     */
    public function run()
    {
        $res = "";

        foreach($this->modules as $module)
        {
            if (method_exists($module, "run")) {
                $res = $module->run();
            }
        }

        return $res;
    }
}
