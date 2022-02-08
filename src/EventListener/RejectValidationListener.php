<?php


namespace App\EventListener;

use App\Events\RejectValidationEvent;
use App\Events\RequestValidationEvent;
use App\Services\FileProcessService;
use Swift_Attachment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RejectValidationListener implements EventSubscriberInterface
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
     * @var FileProcessService
     */
    private $fileProcessService;

    /**
     * IncidentCreatedListener constructor.
     */
    public function __construct(\Swift_Mailer $mailer,
                                \Twig_Environment $twig_Environment,
                                UrlGeneratorInterface $urlGenerator,
                                FileProcessService $fileProcessService)
    {
        $this->mailer = $mailer;
        $this->twig_Environment = $twig_Environment;
        $this->urlGenerator = $urlGenerator;
        $this->fileProcessService = $fileProcessService;
    }

    public static function getSubscribedEvents()
    {
        return [
            RejectValidationEvent::NAME => 'onRejectValidation'
        ];
    }

    public function onRejectValidation(RejectValidationEvent $rejectValidationEvent){

        $subscriberProject = $rejectValidationEvent->getSubscriberProject();

        $body = $this->twig_Environment->render('emails/rejectValidationEmail.html.twig',[
            'subscription' => $subscriberProject
        ]);

        $message = (new \Swift_Message())
            ->setSubject('Votre demande de financement a été rejettée sur CrifatCrowdFunding')
            ->setFrom('crifatcrowdfunding@gmail.com')
            ->setTo([
                $rejectValidationEvent->getSubscriberProject()->getSubscriberId()->getSubscriberEmail(),
            ])
            ->setBody($body,'text/html');

        $this->mailer->send($message);
    }
}