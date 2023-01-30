<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Symfony\Component\HttpFoundation\Request;

class PostCommentController extends Controller 
{
    public function store(Request $request, string $slug)
    {
        $data = $request->request->all();

        $this->validate($request, [
            "name" => "required|max:255",
            "content" => "required|max:500",
        ]);

        $post = (new Post)->findBy("slug", $slug);

        if( !$post ) return back();

        $data["post_id"] = $post->id;

        (new PostComment($post->id))->create($data);

        alert("success", "Commentaire envoyé avec succès, il sera affiché une fois validé.");
        return back();
    }

    public function update(Request $request, int $id)
    {
        $comment = (new PostComment(0))->find($id);

        if( !$comment ) return back();

        (new PostComment(0))->update($comment->id, [
            "validated" => $comment->validated == 0 ? 1 : 0
        ]);

        alert("success", "Commentaire mise à jour avec succès");
        return back();
    }

    public function destroy(Request $request, int $id)
    {
        $comment = (new PostComment(0))->find($id);

        if( !$comment ) return back();
        
        (new PostComment(0))->delete($id);

        alert("success", "Commentaire supprimé avec succès.");
        return back();
    }
}