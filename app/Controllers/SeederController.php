<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class SeederController extends Controller 
{
    /**
     * Seed database
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if( env("APP_ENV") !== "local" ){
            echo "Local mode only, check your .env file";
            exit(1);
        }

        $user = (new User)->create([
            "first_name" => "Luca",
            "last_name" => "Sordetti",
            "email" => "root@root.fr",
            "password" => password_hash("root", PASSWORD_BCRYPT)
        ]);
    }
}