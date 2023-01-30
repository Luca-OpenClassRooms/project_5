<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller 
{
    /**
     * Display index
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

        return $this->render("dashboard/posts/index", compact("posts"));
    }

    /**
     * Display create page
     *
     * @return void
     */
    public function create()
    {
        return $this->render("dashboard/posts/create", ["post" => []]);
    }

    /**
     * Display edit page
     *
     * @param integer $id
     * @return void
     */
    public function edit(int $id)
    {
        $post = (new Post)->findBy("id", $id);

        if( !$post )
            return redirect("dashboard.posts.index");

        return $this->render("dashboard/posts/create", compact("post"));
    }

    /**
     * Store a new post
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {   
        $data = $request->request->all();

        $this->validate($request, [
            "title" => "required|max:255",
            "slug" => "required|max:255",
            "author" => "required|max:255",
            "short_content" => "required",
            "content" => "required",
        ]);

        (new Post)->create($data);

        alert("success", "Article ajouté avec succès.");
        return redirect("dashboard.posts.index");        
    }

    /**
     * Update a post
     *
     * @param Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id)
    {
        $data = $request->request->all();
        $post = (new Post)->findBy("id", $id);

        if( !$post )
            return redirect("dashboard.posts.index");

        $this->validate($request, [
            "title" => "required|max:255",
            "slug" => "required|max:255",
            "author" => "required|max:255",
            "short_content" => "required",
            "content" => "required",
        ]);

        $data["updated_at"] = date("Y-m-d H:i:s");

        (new Post)->update($id, $data);

        alert("success", "Article modifié avec succès.");
        return back();
    }

    /**
     * Remove a post
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        (new Post)->delete($id);
        alert("success", "Article supprimé avec succès.");
        return redirect("dashboard.posts.index");       
    }
}