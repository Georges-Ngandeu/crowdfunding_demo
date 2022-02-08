<?php


namespace App\Events;


use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class NotifyContributorEvent extends Event
{
    const NAME = 'notifycontribution.success';

    /**
     * @var User
     */
    private $user;
    /**
     * @var Project
     */
    private $project;

    /**
     * IncidentCreatedEvent constructor.
     */
    public function __construct(User $user, Project $project)
    {
        $this->user = $user;
        $this->project = $project;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

}