<?php

namespace App\Controllers;

use App\Models\User;

class SeederController extends Controller 
{
    /**
     * Seed database
     *
     * @return void
     */
    public function index()
    {
        if (env("APP_ENV") !== "local") {
            return "Local mode only, check your .env file";
        }

        (new User)->create([
            "first_name" => "Luca",
            "last_name" => "Sordetti",
            "email" => "root@root.fr",
            "password" => password_hash("root", PASSWORD_BCRYPT)
        ]);
    }
}
