<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

/**
 * Ici, on se trouve la connexion SMTP et l'envoi du mail
 */

class MailerService
{
    public function sendMailer($destinaire, $messageSubject, $messageBody,): void
    {
        /**
         * le port 25 et bloqué par la FAI (Fournisseur d'accès à Internet)
         * le 587 c'est le port par défaut du web moderne
         * le 465 a été réaffecté à un autre usage 
         * le 2525 c'est une altérnative a 587 mais il n'est pas un port SMTP
         */
            /**
             * le transporteur sera chargé de communiquer avec votre courtier de messages ou des tiers.
             */
        $bus = Transport::fromDsn('smtp://maximelouis321@gmail.com:hbkjjzkakuqnartj@smtp.gmail.com:587');
        $mailer = new Mailer($bus);
        $email = (new Email())->from('maximelouis321@gmail.com')->to($destinaire)->subject($messageSubject)->html($messageBody);
        $mailer->send($email);
    }
}
