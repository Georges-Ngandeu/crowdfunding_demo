<?php

namespace App\Manager;

use App\Entity\OtpSegment;
use Doctrine\ORM\EntityManagerInterface;

class OtpSegmentManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(OtpSegment $otpSegment)
    {
        $this->entityManager->persist($otpSegment);
        $this->entityManager->flush();
        return $otpSegment;
    }

    public function find($ids)
    {
        $otpSegment = $this->entityManager->getRepository(OtpSegment::class)->find($ids);
        return $otpSegment;
    }

    public function findOneBy($criteria) : ?OtpSegment
    {
        $otpSegment = $this->entityManager->getRepository(OtpSegment::class)->findOneBy($criteria);
        return $otpSegment;
    }

    public function findBy($criteria)
    {
        $otpSegment = $this->entityManager->getRepository(OtpSegment::class)->findBy($criteria);
        return $otpSegment;
    }

    public function delete($ids)
    {

        $otpSegment = $this->entityManager->getRepository(OtpSegment::class)->find($ids);
        if ($otpSegment != null) {
            $this->entityManager->remove($otpSegment);
            $this->entityManager->flush();
        }
        return $otpSegment;
    }
    
}
