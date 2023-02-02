<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

use Tleckie\UrlSigner\Exception\UnsignedException;
use Tleckie\UrlSigner\Exception\ExpiredUriException;
use Tleckie\UrlSigner\Signer;

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

        if ($exist) {
            alert("error", "Cette e-mail est déjà utilisé.");
            return back();
        }

        $user = (new User)->create([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "email" => $data["email"],
            "password" => password_hash($data["password"], PASSWORD_BCRYPT),
        ]);

        $signer = new Signer(env("APP_SECRET"), 'signature');

        $mailer = app("mailer");

        $email = $mailer->email()
            ->from($user->email)
            ->to(env("MAIL_FROM_ADDRESS"))
            ->subject("Confirmation de votre adresse e-mail")
            ->html($this->render("emails/confirmation", [
                "user" => $user,
                "url" => $signer->sign(url("auth.confirm", ["email" => $user->email]))
            ]));

        $mailer->send($email);

        alert("success", "Inscription effectuée, un e-mail de confirmation vous a été envoyé.");
        return redirect("auth.login");
    }

    public function confirm(Request $request)
    {
        $path = urldecode($request->getRequestUri());
        $fullPath = rtrim(env("APP_URL", "/")).$path;
     
        $signer = new Signer(env("APP_SECRET"), 'signature');

        try {
            $signer->validate($fullPath);
        } catch(ExpiredUriException $exception) {
            return redirect("index");
        } catch(UnsignedException $exception) {
            return redirect("index");
        }
        
        $user = (new User)->findBy("email", $request->get("email"));

        if (!$user) {
            return redirect("index");
        }

        (new User)->update($user->id, [
            "email_verified_at" => date("Y-m-d H:i:s")
        ]);

        alert("success", "Votre compte a été activé.");
        return redirect("auth.login");
    }
}
