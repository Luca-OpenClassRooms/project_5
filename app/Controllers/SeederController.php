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
        if( env("APP_ENV") !== "local" )
            die("Local mode only, check your .env file");

        $user = (new User)->create([
            "first_name" => "Luca",
            "last_name" => "Sordetti",
            "email" => "root@root.fr",
            "password" => password_hash("root", PASSWORD_BCRYPT)
        ]);
    }
}