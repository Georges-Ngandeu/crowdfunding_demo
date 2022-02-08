<?php


namespace App\EventListener;


use App\Events\ContributionSucceedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContributionSucceedListener implements EventSubscriberInterface
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
            ContributionSucceedEvent::NAME => 'onContributionAccepted'
        ];
    }

    public function onContributionAccepted(ContributionSucceedEvent $contributionSucceedEvent){

        $body = $this->twig_Environment->render('emails/contributionaccepted.html.twig',[
            'project' => $contributionSucceedEvent->getSponsoredProject()
        ]);

        $message = (new \Swift_Message())
            ->setSubject(' Une contribution a été éffectué sur le site de Crifatcrowdfunding')
            ->setFrom('crifatcrowdfunding@gmail.com')
            ->setTo([
                'georgesngandeu@gmail.com',
            ])
            ->setBody($body,'text/html');

        $this->mailer->send($message);
    }
}