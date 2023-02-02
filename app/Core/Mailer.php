<?php

namespace App\Core;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer as MailerClass;
use Symfony\Component\Mime\Email;

class Mailer
{
    private $mailer;

    public function __construct()
    {
        $config = config("mail");
        $transport = Transport::fromDsn("smtp://{$config['username']}:{$config['password']}@{$config['host']}:{$config['port']}?encryption={$config['encryption']}}");
        $mailer = new MailerClass($transport);

        $this->mailer = $mailer;
    }

    /**
     * Create a new email
     *
     * @return Email
     */
    public function email()
    {
        return (new Email());
    }

    /**
     * Send an email
     *
     * @param Email $email
     * @return void
     */
    public function send(Email $email)
    {
        // if( !$this->mailer ) return;
        $this->mailer->send($email);
    }
}