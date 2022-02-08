<?php


namespace App\EventListener;

use App\Events\RequestValidationEvent;
use App\Services\FileProcessService;
use Swift_Attachment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestValidationListener implements EventSubscriberInterface
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
            RequestValidationEvent::NAME => 'onRequestValidation'
        ];
    }

    public function onRequestValidation(RequestValidationEvent $requestValidationEvent){

        $subscriberProject = $requestValidationEvent->getSubscriberProject();

        $body = $this->twig_Environment->render('emails/requestValidateEmail.html.twig',[
            'subscriberProject' => $subscriberProject,
        ]);

        $message = (new \Swift_Message())
            ->setSubject('Votre soucription  a été validée sur CrifatInvest')
            ->setFrom('crifatinvest@gmail.com')
            ->setTo([
                $requestValidationEvent->getSubscriberProject()->getSubscriberId()->getSubscriberEmail(),
            ])
            ->setBody($body,'text/html')
            ->attach(Swift_Attachment::fromPath('companies_documents/'.$this->fileProcessService->formattedProjectName($subscriberProject->getProjectId()->getProjectName()).'/'.$subscriberProject->getProjectId()->getProjectDocuments()[$subscriberProject->getProjectId()->getProjectName()][0]))
            ->attach(Swift_Attachment::fromPath('companies_documents/'.$this->fileProcessService->formattedProjectName($subscriberProject->getProjectId()->getProjectName()).'/'.$subscriberProject->getProjectId()->getProjectDocuments()[$subscriberProject->getProjectId()->getProjectName()][1]));

        $this->mailer->send($message);
    }
}