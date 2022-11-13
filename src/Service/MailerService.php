<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;





class MailerService
{
    public function sendMailer($destinaire,$messageSubject, $messageBody,):void{
        
        $bus = Transport::fromDsn('smtp://maximelouis321@gmail.com:hbkjjzkakuqnartj@smtp.gmail.com:587');
        $mailer = new Mailer($bus);
        $email = (new Email())->from('maximelouis321@gmail.com')->to($destinaire)->subject($messageSubject)->html($messageBody);
        $mailer->send($email);
    }

}
