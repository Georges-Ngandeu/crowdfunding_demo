<?php


namespace App\EventListener;


use App\Events\EmailValidationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EmailValidationListener implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig_Environment;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * IncidentCreatedListener constructor.
     */
    public function __construct(\Swift_Mailer $mailer,
                                \Twig_Environment $twig_Environment,
                                UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->twig_Environment = $twig_Environment;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            EmailValidationEvent::NAME => 'onEmailValidation'
        ];
    }

    public function onEmailValidation(EmailValidationEvent $emailValidationEvent){

        $body = $this->twig_Environment->render('emails/validateEmail.html.twig',[
            'subscriber' => $emailValidationEvent->getSubscriber(),
            'url' => $this->urlGenerator->generate('userEmailValidation', [
                'token' => $emailValidationEvent->getSubscriber()->getUser()->getConfirmationToken(),
                'id' => $emailValidationEvent->getSubscriber()->getUser()->getId()
            ], UrlGeneratorInterface::ABSOLUTE_URL)
        ]);

        $message = (new \Swift_Message())
            ->setSubject(' Confirmer votre email sur CrifatInvest')
            ->setFrom('crifatinvest@gmail.com')
            ->setTo([
                $emailValidationEvent->getSubscriber()->getUser()->getEmail(),
            ])
            ->setBody($body,'text/html');

        $this->mailer->send($message);
    }
}