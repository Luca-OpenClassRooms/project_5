<?php

namespace App\Controllers;

use App\Models\Post;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller 
{

    
    /**
     * Display all posts
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $posts = (new Post)->paginate(
            $request->query->get("page", 1), 
            $request->query->get("perPage", 5)
        );

        return $this->render("index", compact("posts"));
    }
}