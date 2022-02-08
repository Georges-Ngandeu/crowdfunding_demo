<?php


namespace App\Events;


use App\Entity\SubscriberProject;
use Symfony\Component\EventDispatcher\Event;

class EngagementSentEvent extends Event
{
    const NAME = 'engagement_sent.success';

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