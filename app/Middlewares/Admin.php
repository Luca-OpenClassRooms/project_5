<?php

namespace App\Middlewares;
use Symfony\Component\HttpFoundation\Request;

class Admin
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

        if( $_SESSION["user"]->is_admin !== 1 )
            return redirect("index");
    }
}