<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller 
{
    /**
     * Display contact form
     *
     * @return void
     */
    public function index()
    {
        return $this->render("contact");
    }


    /**
     * Send contact form
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
            "email" => "required|email",
            "message" => "required"
        ]);

        $mailer = app("mailer");

        $email = $mailer->email()
            ->from($data["email"])
            ->to(env("MAIL_FROM_ADDRESS"))
            ->replyTo($data["email"])
            ->subject("Nouveau message de : {$data["first_name"]} {$data["last_name"]}")
            ->html($this->render("emails/contact", [...$data]));

        $mailer->send($email);

        alert("success", "Votre message a bien été envoyé.");
        return back();
    }
}
