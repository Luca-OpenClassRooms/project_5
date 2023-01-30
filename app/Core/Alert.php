<?php

namespace App\Core;

class Alert
{
    public function __construct()
    {
        if (!isset($_SESSION["alerts"])) {
            $_SESSION["alerts"] = [];
        }
    }

    /**
     * Add alert to session
     *
     * @param string $type
     * @param string $message
     * @return void
     */
    public function add(string $type, string $message)
    {
        if (!isset($_SESSION["alerts"][$type])) {
            $_SESSION["alerts"][$type] = [];
        }

        $_SESSION["alerts"][$type][] = $message;
    }
    
    /**
     * Run the module
     *
     * @return void
     */
    public function run()
    {
        $_SESSION["alerts"] = [];
    }
}