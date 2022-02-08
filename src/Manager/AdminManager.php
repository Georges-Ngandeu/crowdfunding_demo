<?php

namespace App\Manager;

use App\Entity\Admin;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AdminManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Admin $admin)
    {
        $this->entityManager->persist($admin);
        $this->entityManager->flush();
        return $admin;
    }

    public function find($ids)
    {
        $admin = $this->entityManager->getRepository(Admin::class)->find($ids);
        return $admin;
    }

    public function findOneBy($criteria): ?Admin
    {
        $admin = $this->entityManager->getRepository(Admin::class)->findOneBy($criteria);
        return $admin;
    }

    public function findBy($criteria)
    {
        $admin = $this->entityManager->getRepository(Admin::class)->findBy($criteria);
        return $admin;
    }

    public function delete($ids){
        $admin = $this->entityManager->getRepository(Admin::class)->find($ids);
        if ($admin != null) {
            $this->entityManager->remove($admin);
            $this->entityManager->flush();
        }
        return $admin;
    }

    public function findAll(){
        $companies = $this->entityManager->getRepository(Admin::class)->findAll();
        return $companies;
    }
}