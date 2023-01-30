<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * Display login page
     *
     * @return void
     */
    public function index()
    {
        return $this->render("auth/login");
    }  

    /**
     * Try to authentification an user
     *
     * @param Request $request
     * @return void
     */
    public function authentificate(Request $request)
    {
        $email = $request->get("email");
        $password = $request->get("password");

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            alert("error", "E-mail invalide.");
            return back();
        }

        $user = (new User())->findBy("email", $email);

        if (!$user) {
            alert("error", "Identifiants incorrect.");
            return back();
        }

        if (!password_verify($password, $user->password)) {
            alert("error", "Identifiants incorrect.");
            return back();
        }

        $_SESSION["user"] = $user;

        alert("success", "Connexion effectuée.");

        return redirect("dashboard.index");
    }

    /**
     * Logout current user
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION["user"]);
        alert("success", "Déconnexion effectuée.");
        return redirect("index"); 
    }
}