<?php

namespace App\Middlewares;

class Guest
{
    /**
     * Process middleware
     *
     * @return void
     */
    public function process()
    {
        if( isset($_SESSION["user"]) && !empty($_SESSION["user"]) )
            return redirect("dashboard.index");
    }
}