<?php

namespace App\Middlewares;
use Symfony\Component\HttpFoundation\Request;

class Auth
{
    /**
     * Process middleware
     *
     * @param Request $request
     * @return void
     */
    public function process(Request $request)
    {
        if( !isset($_SESSION["user"]) || empty($_SESSION["user"]) )
            return redirect("index");
    }
}