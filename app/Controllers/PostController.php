<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller 
{
    public function show(Request $request, string $slug)
    {
        $post = (new Post)->find($slug);
        $comments = (new PostComment($post->id))->all();

        return $this->render("post", compact("post", "comments"));
    }
}