<?php

namespace App\Manager;

use App\Entity\Subscriber;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class SubscriberManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Subscriber $subscriber)
    {
        $this->entityManager->persist($subscriber);
        $this->entityManager->flush();
        return $subscriber;
    }

    public function find($ids)
    {
        $subscriber = $this->entityManager->getRepository(Subscriber::class)->find($ids);
        return $subscriber;
    }

    public function findOneBy($criteria): ?Subscriber
    {
        $subscriber = $this->entityManager->getRepository(Subscriber::class)->findOneBy($criteria);
        return $subscriber;
    }

    public function findBy($criteria)
    {
        $subscriber = $this->entityManager->getRepository(Subscriber::class)->findBy($criteria);
        return $subscriber;
    }

    public function delete($ids){
        $subscriber = $this->entityManager->getRepository(Subscriber::class)->find($ids);
        if ($subscriber != null) {
            $this->entityManager->remove($subscriber);
            $this->entityManager->flush();
        }
        return $subscriber;
    }

    public function findAll(){
        $companies = $this->entityManager->getRepository(Subscriber::class)->findAll();
        return $companies;
    }
}