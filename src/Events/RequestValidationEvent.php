<?php


namespace App\Events;


use App\Entity\Project;
use App\Entity\SubscriberProject;
use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class RequestValidationEvent extends Event
{
    const NAME = 'request_validation.success';

    /**
     * @var SubscriberProject
     */
    private $subscriberProject;

    /**
     * IncidentCreatedEvent constructor.
     */
    public function __construct(SubscriberProject $subscriberProject)
    {

        $this->subscriberProject = $subscriberProject;
    }

    /**
     * @return SubscriberProject
     */
    public function getSubscriberProject(): SubscriberProject
    {
        return $this->subscriberProject;
    }

}