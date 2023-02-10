<?php

namespace App\Middlewares;

use App\Models\User as ModelsUser;

class User
{
    /**
     * Process middleware
     *
     * @return void
     */
    public function process()
    {
        if (!isset($_SESSION["user"]) || empty($_SESSION["user"]))
            return true;

        $user = $_SESSION["user"];

        $dbUser = (new ModelsUser)->findBy("id", $user->id);

        if (!$dbUser) {
            unset($_SESSION["user"]);
            return true;
        }

        $_SESSION["user"] = $dbUser;
    }
}
