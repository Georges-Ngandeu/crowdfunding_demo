<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function find($ids)
    {
        $user = $this->entityManager->getRepository(User::class)->find($ids);
        return $user;
    }

    public function findOneBy($criteria): ?User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy($criteria);
        return $user;
    }

    public function findBy($criteria)
    {
        $user = $this->entityManager->getRepository(User::class)->findBy($criteria);
        return $user;
    }

    public function delete($ids){
        $user = $this->entityManager->getRepository(User::class)->find($ids);
        if ($user != null) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
        return $user;
    }

    public function findAll(){
        $companies = $this->entityManager->getRepository(User::class)->findAll();
        return $companies;
    }
}