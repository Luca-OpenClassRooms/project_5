<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class PasswordResetController extends Controller
{
    /**
     * Display password reset page
     *
     * @return void
     */
    public function index()
    {
        return $this->render("auth/password/reset");
    }

    /**
     * Reset password
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request, string $token)
    {
        $this->validate($request, [
            "password" => "required|max:255",
            "password_confirmation" => "required|same:password"
        ]);

        $email = $request->get("email");
        $password = $request->get("password");

        $passwordReset = (new PasswordReset)->findBy("token", $token);

        if (!$passwordReset) {
            alert("danger", "Le lien de réinitialisation de mot de passe est invalide.");
            return back();
        }

        if ($passwordReset->email !== $email) {
            alert("danger", "Le lien de réinitialisation de mot de passe est invalide.");
            return back();
        }

        $user = (new User)->findBy("email", $email);

        if (!$user) {
            alert("danger", "Le lien de réinitialisation de mot de passe est invalide.");
            return back();
        }

        (new User)->update($user->id, [
            "password" => password_hash($password, PASSWORD_BCRYPT)
        ]);

        (new PasswordReset)->deleteToken($passwordReset->token, $passwordReset->email);

        alert("success", "Votre mot de passe a été réinitialisé avec succès.");
        return redirect("auth.login");
    }
}