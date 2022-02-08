<?php


namespace App\EventListener;


use App\Events\EngagementSentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EngagementSentListener implements EventSubscriberInterface
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
            EngagementSentEvent::NAME => 'onEngagementSent'
        ];
    }

    public function onEngagementSent(EngagementSentEvent $engagementSentEvent){

        $body = $this->twig_Environment->render('emails/engagementSentEmail.html.twig',[
            'subscriberProject' => $engagementSentEvent->getSubscriberProject(),
        ]);

        $message = (new \Swift_Message())
            ->setSubject(' Une souscription a été enregistré sur CrifatInvest')
            ->setFrom('crifatinvest@gmail.com')
            ->setTo([
                'georgesngandeu@gmail.com',
            ])
            ->setBody($body,'text/html');

        $this->mailer->send($message);
    }
}