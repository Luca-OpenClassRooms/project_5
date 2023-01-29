<?php

namespace App\Controllers;

use App\Models\Post;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller 
{
    public function show(Request $request, string $slug)
    {
        $post = (new Post)->find($slug);

        return $this->render("blog", compact("post"));
    }
}