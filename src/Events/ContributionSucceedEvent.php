<?php


namespace App\Events;


use App\Entity\Project;
use Symfony\Component\EventDispatcher\Event;

class ContributionSucceedEvent extends Event
{
    const NAME = 'contribution.success';

    /**
     * @var Project
     */
    private $sponsoredProject;

    /**
     * IncidentCreatedEvent constructor.
     */
    public function __construct(Project $sponsoredProject)
    {
        $this->sponsoredProject = $sponsoredProject;
    }

    /**
     * @return Project
     */
    public function getSponsoredProject(): Project
    {
        return $this->sponsoredProject;
    }

}