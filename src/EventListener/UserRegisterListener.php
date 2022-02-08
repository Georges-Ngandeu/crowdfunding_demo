<?php


namespace App\EventListener;


use App\Events\UserRegisterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserRegisterListener implements EventSubscriberInterface
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
            UserRegisterEvent::NAME => 'onUserRegister'
        ];
    }

    public function onUserRegister(UserRegisterEvent $userRegisterEvent){

        $body = $this->twig_Environment->render('emails/userCreatedEmail.html.twig',[
            'subscriber' => $userRegisterEvent->getSubscriber()
        ]);

        $message = (new \Swift_Message())
            ->setSubject(' Un compte a été crée sur CrifatInvest')
            ->setFrom('crifatinvest@gmail.com')
            ->setTo([
                'georgesngandeu@gmail.com',
            ])
            ->setBody($body,'text/html');

        $this->mailer->send($message);
    }
}