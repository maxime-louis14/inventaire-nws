<?php

namespace App\service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @param string $subject
 * @param string $from
 * @param string $to
 * @param string $template
 * @param string $parametres
 */

class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {
    }
    public function sendEmail(string $subject,): void
    {
        // $to = "maximelouis321@gmail.com";
        // $content = "<p>See Twig integration for better HTML integration!</p>";
        // $subject = "Time for Symfony Mailer!";


        $email = (new Email())
            ->from('maximelouis321@gmail.com')
            ->to($to)
            ->subject($subject)
            ->text('Sending emails is fun again!')
            ->html($content);

        $this->mailer->send($email);

        // ...
    }
}
