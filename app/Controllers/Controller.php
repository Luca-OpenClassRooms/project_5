<?php

namespace App\Controllers;

class Controller 
{
    private $loader;
    private $twig;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader("../resources/views");
        $this->twig = new \Twig\Environment($this->loader, [
            'cache' => false,
        ]);
    }

    protected function render($view, $params = [])
    {
        return $this->twig->render($view . ".html.twig", $params);
    }
}