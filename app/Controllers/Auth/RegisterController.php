<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    /**
     * Display register page
     *
     * @return void
     */
    public function index()
    {
        return $this->render("auth/register");
    }  

    /**
     * Create a new user
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $data = $request->request->all();

        $this->validate($request, [
            "first_name" => "required|max:255",
            "last_name" => "required|max:255",
            "email" => "required|email|max:255",
            "password" => "required|max:255",
            "password_confirmation" => "required|same:password"
        ]);

        $exist = (new User)->findBy("email", $data["email"]);

        if( $exist ){
            alert("error", "Cette e-mail est déjà utilisé.");
            return back();
        }

        $user = (new User)->create([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "email" => $data["email"],
            "password" => password_hash($data["password"], PASSWORD_BCRYPT),
        ]);

        $_SESSION["user"] = (new User)->findBy("id", $user->id);

        alert("success", "Inscription effectuée.");
        return redirect("index");
    }
}