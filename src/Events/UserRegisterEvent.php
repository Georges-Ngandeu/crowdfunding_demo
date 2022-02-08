<?php


namespace App\Events;


use App\Entity\Subscriber;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event
{
    const NAME = 'user_register.success';

    /**
     * @var Subscriber
     */
    private $subscriber;

    /**
     * IncidentCreatedEvent constructor.
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @return Subscriber
     */
    public function getSubscriber(): Subscriber
    {
        return $this->subscriber;
    }

}