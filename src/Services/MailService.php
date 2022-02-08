<?php

namespace App\Services;

use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;
use Twig\Environment;


class MailService
{

    private $mailer;

    private $twig;

    
    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send(string $from, array $email, string $object, string $content = "")
    {
        $this->full($from, $email, $object, $content);
    }


    public function full(
        string $from,
        array $email,
        string $object,
        string $content = null,
        $data = null,
        array $attach = null,
        string $temp = "emails/base.html.twig"
    ) {
        $message = (new Swift_Message($object))
            ->setFrom(['support@afrikpay.com' => $from])
            ->setTo($email)
            ->setBody(
                $this->twig->render(
                    // templates/emails/registration.html.twig
                    $temp,
                    ['data' => $data,
                     'content' => $content]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->twig->render(
                    // templates/emails/registration.txt.twig
                    'emails/base.txt.twig',
                    ['content' => $content]
                ),
                'text/plain'
            )
        ;
        
        if ($attach != null) {
            foreach ($attach as $value) {
                // Code to be executed
                $message->attach(Swift_Attachment::fromPath($value));
            }
        }
        

        $this->mailer->send($message);
    }
}
