<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;





class MailerService
{
    public function sendMailer($destinaire,$messageSubject, $messageBody,):void{
        
        $tgv = Transport::fromDsn('smtp://maximelouis321@gmail.com:hbkjjzkakuqnartj@smtp.gmail.com:587');
        $mailer = new Mailer($tgv);
        $email = (new Email())->from('maximelouis321@gmail.com')->to($destinaire)->subject($messageSubject)->html($messageBody);
        $mailer->send($email);
    }

}
