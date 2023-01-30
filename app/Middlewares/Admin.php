<?php

namespace App\Middlewares;

class Admin
{
    /**
     * Process middleware
     *
     * @return void
     */
    public function process()
    {
        if( !isset($_SESSION["user"]) || empty($_SESSION["user"]) )
            return redirect("index");

        if( $_SESSION["user"]->is_admin !== 1 )
            return redirect("index");
    }
}