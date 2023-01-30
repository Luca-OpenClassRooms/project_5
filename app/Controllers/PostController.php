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
        
        $comments = (new PostComment($post->id, isset($_SESSION["user"]) && $_SESSION["user"]->is_admin))->paginate(
            $request->query->get("page", 1), 
            $request->query->get("perPage", 5)
        );

        return $this->render("post", compact("post", "comments"));
    }
}