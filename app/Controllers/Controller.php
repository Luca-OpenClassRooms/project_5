<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Twig\TwigFunction;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Rakit\Validation\Validator;

class Controller
{
    /**
     * Twig loader
     *
     * @var FilesystemLoader
     */
    private $loader;

    /**
     * Twig environment
     *
     * @var Environment
     */
    private $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader("../resources/views");
        $this->twig = new Environment($this->loader, ['cache' => false]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('user', $_SESSION["user"] ?? false);
        $this->twig->addGlobal("is_admin", isset($_SESSION["user"]) && $_SESSION["user"]->is_admin);
        $this->twig->addFunction(new TwigFunction("route", function (...$args) {
            return route(...$args);
        }));
    }

    
    /**
     * Render a twig template
     *
     * @param string $view
     * @param array $params
     * @return void
     */
    protected function render($view, $params=[])
    {
        return $this->twig->render($view.".html.twig", $params);
    }

    /**
     * Validate data from request
     *
     * @param Request $request
     * @param array $validation
     * @return void
     */
    public function validate(Request $request, array $validation)
    {
        $data = $request->request->all();

        $validation = (new Validator)->validate($data, $validation);

        if ($validation->fails()) {
            $errors = $validation->errors();
            $error = $errors->firstOfAll();

            $key = ucfirst(array_keys($error)[0]);
            $val = strtolower(array_values($error)[0]);
            alert("error", "$key: $val");

            return back();
        }
    }
}
