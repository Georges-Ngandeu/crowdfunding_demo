<?php

namespace App\Manager;

use App\Entity\OtpLine;
use Doctrine\ORM\EntityManagerInterface;

class OtpLineManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(OtpLine $otpLine)
    {
        $this->entityManager->persist($otpLine);
        $this->entityManager->flush();
        return $otpLine;
    }

    public function find($ids)
    {
        $otpLine = $this->entityManager->getRepository(OtpLine::class)->find($ids);
        return $otpLine;
    }

    public function findOneBy($criteria) : ?OtpLine
    {
        $otpLine = $this->entityManager->getRepository(OtpLine::class)->findOneBy($criteria);
        return $otpLine;
    }

    public function findBy($criteria, $order)
    {
        $otpLine = $this->entityManager->getRepository(OtpLine::class)->findBy($criteria, $order);
        return $otpLine;
    }

    public function delete($ids)
    {

        $otpLine = $this->entityManager->getRepository(OtpLine::class)->find($ids);
        if ($otpLine != null) {
            $this->entityManager->remove($otpLine);
            $this->entityManager->flush();
        }
        return $otpLine;
    }

    
}
