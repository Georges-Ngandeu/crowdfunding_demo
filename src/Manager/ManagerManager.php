<?php

namespace App\Manager;

use App\Entity\Manager;
use Doctrine\ORM\EntityManagerInterface;

class ManagerManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Manager $manager)
    {
        $this->entityManager->persist($manager);
        $this->entityManager->flush();
        return $manager;
    }

    public function find($ids)
    {
        $manager = $this->entityManager->getRepository(Manager::class)->find($ids);
        return $manager;
    }

    public function findOneBy($criteria): ?Manager
    {
        $manager = $this->entityManager->getRepository(Manager::class)->findOneBy($criteria);
        return $manager;
    }

    public function findBy($criteria, $orderby)
    {
        $manager = $this->entityManager->getRepository(Manager::class)->findBy($criteria, $orderby);
        return $manager;
    }

    public function delete($ids){
        $manager = $this->entityManager->getRepository(Manager::class)->find($ids);
        if ($manager != null) {
            $this->entityManager->remove($manager);
            $this->entityManager->flush();
        }
        return $manager;
    }

    public function findAll(){
        $companies = $this->entityManager->getRepository(Manager::class)->findAll();
        return $companies;
    }
}