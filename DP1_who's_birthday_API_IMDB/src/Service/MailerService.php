<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{

    public function __construct(private \Symfony\Component\Mailer\MailerInterface $mailer)
    {
    }

    public function sendEmail()
    {
        $email = (new Email())
            ->from('testmailsolacroup@gmail.com')
            ->to('gaetan.yvert@institutsolacroup.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('I believe')
            ->text('I can Fly');
        // ->html('<p>See Twig integration for better HTML integration!</p>');
        dd($this->mailer->send($email));
        return $this->mailer->send($email);

        // ...
    }
}
