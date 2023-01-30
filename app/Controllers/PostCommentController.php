<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Symfony\Component\HttpFoundation\Request;

class PostCommentController extends Controller 
{
    /**
     * Store a new comment on a post
     *
     * @param Request $request
     * @param string $slug
     * @return void
     */
    public function store(Request $request, string $slug)
    {
        $data = $request->request->all();

        $this->validate($request, [
            "content" => "required|max:500",
        ]);

        $post = (new Post)->findBy("slug", $slug);

        if (!$post) return back();

        $data["post_id"] = $post->id;
        $data["user_id"] = $_SESSION["user"]->id;

        (new PostComment($post->id))->create($data);

        alert("success", "Commentaire envoyé avec succès, il sera affiché une fois validé.");
        return back();
    }

    /**
     * Update a comment status
     *
     * @param integer $id
     * @return void
     */
    public function update(int $id)
    {
        $comment = (new PostComment(0))->find($id);

        if( !$comment ) return back();

        (new PostComment(0))->update($comment->id, [
            "validated" => $comment->validated == 0 ? 1 : 0
        ]);

        alert("success", "Commentaire mise à jour avec succès");
        return back();
    }

    /**
     * Remove a comment
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        $comment = (new PostComment(0))->find($id);

        if( !$comment ) return back();
        
        (new PostComment(0))->delete($id);

        alert("success", "Commentaire supprimé avec succès.");
        return back();
    }
}