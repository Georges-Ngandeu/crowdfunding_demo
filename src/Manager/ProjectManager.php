<?php

namespace App\Manager;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Project $project)
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
        return $project;
    }

    public function find($ids)
    {
        $project = $this->entityManager->getRepository(Project::class)->find($ids);
        return $project;
    }

    public function findOneBy($criteria): ?Project
    {
        $project = $this->entityManager->getRepository(Project::class)->findOneBy($criteria);
        return $project;
    }

    public function findBy($criteria)
    {
        $project = $this->entityManager->getRepository(Project::class)->findBy($criteria);
        return $project;
    }

    public function delete($ids){
        $project = $this->entityManager->getRepository(Project::class)->find($ids);
        if ($project != null) {
            $this->entityManager->remove($project);
            $this->entityManager->flush();
        }
        return $project;
    }

    public function findAll(){
        $companies = $this->entityManager->getRepository(Project::class)->findAll();
        return $companies;
    }
}