<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller 
{
    /**
     * Return post page
     *
     * @param Request $request
     * @param string $slug
     * @return void
     */
    public function show(Request $request, string $slug)
    {
        $post = (new Post)->find($slug);

        if( !$post ) return redirect("index");
        
        $comments = (new PostComment($post->id))->all();

        return $this->render("post", compact("post", "comments"));
    }
}