<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class PasswordForgotController extends Controller
{
    /**
     * Display password forgot page
     *
     * @return void
     */
    public function index()
    {
        return $this->render("auth/password/forgot");
    }

    /**
     * Send email to reset password
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email"
        ]);

        $email = $request->get("email");

        $user = (new User)->findBy("email", $email);

        if (!$user) {
            alert("success", "Un mail de confirmation vous a été envoyé.");
            return back();
        }
        
        $token = str_random(60);

        (new PasswordReset)->create([
            "email" => $email,
            "token" => $token
        ]);

        $mailer = app("mailer");

        $email = $mailer->email()
            ->from(env("MAIL_FROM_ADDRESS"))
            ->to($email)
            ->subject("Réinitialisation de votre mot de passe")
            ->html($this->render("emails/password/forgot", [
                "user" => $user,
                "token" => $token
            ]));

        $mailer->send($email);

        alert("success", "Un mail de confirmation vous a été envoyé.");
        return back();
    }
}
