<?php

namespace App\Manager;

use App\Entity\SubscriberProject;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class SubscriberProjectManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(SubscriberProject $subscriberProject)
    {
        $this->entityManager->persist($subscriberProject);
        $this->entityManager->flush();
        return $subscriberProject;
    }

    public function find($ids)
    {
        $subscriberProject = $this->entityManager->getRepository(SubscriberProject::class)->find($ids);
        return $subscriberProject;
    }

    public function findOneBy($criteria): ?SubscriberProject
    {
        $subscriberProject = $this->entityManager->getRepository(SubscriberProject::class)->findOneBy($criteria);
        return $subscriberProject;
    }

    public function findBy($criteria)
    {
        $subscriberProject = $this->entityManager->getRepository(SubscriberProject::class)->findBy($criteria);
        return $subscriberProject;
    }

    public function delete($ids){
        $subscriberProject = $this->entityManager->getRepository(SubscriberProject::class)->find($ids);
        if ($subscriberProject != null) {
            $this->entityManager->remove($subscriberProject);
            $this->entityManager->flush();
        }
        return $subscriberProject;
    }

    public function findAll(){
        $companies = $this->entityManager->getRepository(SubscriberProject::class)->findAll();
        return $companies;
    }
}
