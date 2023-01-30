<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

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

        $config = config("mail");

        $transport = Transport::fromDsn("smtp://{$config['username']}:{$config['password']}@{$config['host']}:{$config['port']}?encryption={$config['encryption']}}");
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from($data["email"])
            ->to(env("MAIL_FROM_ADDRESS"))
            ->replyTo($data["email"])
            ->subject("Nouveau message de : {$data["first_name"]} {$data["last_name"]}")
            ->html($this->render("emails/contact", [
                ...$data
            ]));

        $mailer->send($email);

        alert("success", "Votre message a bien été envoyé.");
        return back();
    }
}