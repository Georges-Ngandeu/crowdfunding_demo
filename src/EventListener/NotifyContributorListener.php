<?php


namespace App\EventListener;


use App\Events\NotifyContributorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotifyContributorListener implements EventSubscriberInterface
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
     * IncidentCreatedListener constructor.
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig_Environment)
    {
        $this->mailer = $mailer;
        $this->twig_Environment = $twig_Environment;
    }

    public static function getSubscribedEvents()
    {
        return [
            NotifyContributorEvent::NAME => 'onContributionAccepted'
        ];
    }

    public function onContributionAccepted(NotifyContributorEvent $notifyContributorEvent){

        $body = $this->twig_Environment->render('emails/contributorNotification.html.twig',[
            'project' => $notifyContributorEvent->getProject(),
            'user' => $notifyContributorEvent->getUser()
        ]);

        $message = (new \Swift_Message())
            ->setSubject(' Votre contribution sur Crifatcrowdfunding a été enregistré avec succès')
            ->setFrom('crifatcrowdfunding@gmail.com')
            ->setTo([
                $notifyContributorEvent->getUser()->getEmail(),
            ])
            ->setBody($body,'text/html');

        $this->mailer->send($message);
    }
}