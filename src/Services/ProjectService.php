<?php

namespace App\Services;

use App\Entity\Project;
use App\Manager\AdminManager;
use App\Manager\AuthorManager;
use App\Manager\ProjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 01/04/2020
 * Time: 15:46
 */
class ProjectService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManagerInterface;
    /**
     * @var ProjectManager
     */
    private $projectManager;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var FileProcessService
     */
    private $fileProcessService;
    /**
     * @var AdminManager
     */
    private $adminManager;
    /**
     * @var Security
     */
    private $security;

    /**
     * ProjectService constructor.
     */
    public function __construct(EntityManagerInterface $entityManagerInterface,
                                ProjectManager $projectManager,
                                AdminManager $adminManager,
                                EventDispatcherInterface $eventDispatcher,
                                FileProcessService $fileProcessService,
                                Security $security
                                )
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->projectManager = $projectManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->fileProcessService = $fileProcessService;
        $this->adminManager = $adminManager;
        $this->security = $security;
    }

    public function createProject(
                                  $project_name,
                                  $project_short_description,
                                  $project_cost,
                                  $project_startdate,
                                  $project_enddate,
                                  $project_mainImage,
                                  $project_images,
                                  $project_long_description,
                                  $project_documents,
                                  $project_videoUrl,
                                  $number_part,
                                  $min_number_part,
                                  $userId
    ){

        $project = new Project();
        $project->setProjectName($project_name);
        $project->setProjectShortdescription($project_short_description);
        $project->setProjectCost($project_cost);
        $project->setProjectStartdate($project_startdate);
        $project->setProjectEnddate($project_enddate);
        $project->setProjectLongdescription($project_long_description);
        $project->setProjectVideourl($project_videoUrl);
        $project->setProjectNumberaction($number_part);
        $project->setProjectMinnumberaction($min_number_part);

//        $admin = $this->adminManager->find($userId);
//        dump($admin); die;
//        $project->setAdminId($admin);

        if(isset($project_mainImage)){
            $this->fileProcessService->UploadMainImage($project_mainImage, $project);
        }

        if(isset($project_images)){

            //store the files in an array
            $uploadedFiles = array();
            foreach($project_images as $key => $project_image){
                array_push($uploadedFiles, $project_image);
            }

            //upload each of the file
            foreach($uploadedFiles as $key => $uploadedFile){
                $this->fileProcessService->UploadImage($uploadedFile, $project);
            }
        }

        if(isset($project_documents)){

            //store the files in an array
            $uploadedFiles = array();
            foreach($project_documents as $key => $project_document){
                array_push($uploadedFiles, $project_document);
            }

            //upload each of the file
            foreach($uploadedFiles as $key => $uploadedFile){
                $this->fileProcessService->UploadDocument($uploadedFile, $project);
            }
        }

        $this->projectManager->save($project);

        return $project;

    }

    public function getAllPublishedProjects(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $qb->select( 'p' )
            ->from( 'App\Entity\Project',  'p' )
            ->where( 'p.project_publish = 1')
            ->orderBy('p.project_creationdate', 'DESC');

        $projects = $qb->getQuery()->getResult();

        return  $projects;
    }

    public function editProject(
        $project_short_description,
        $project_cost,
        $project_startdate,
        $project_enddate,
        $project_long_description,
        $project_videoUrl,
        $number_part,
        $min_number_part,
        $project

    ){
        $project->setProjectShortdescription($project_short_description);
        $project->setProjectCost($project_cost);
        $project->setProjectStartdate($project_startdate);
        $project->setProjectEnddate($project_enddate);
        $project->setProjectLongdescription($project_long_description);
        $project->setProjectVideourl($project_videoUrl);
        $project->setProjectNumberaction($number_part);
        $project->setProjectMinnumberaction($min_number_part);

        $this->projectManager->save($project);

        return $project;
    }

    public function getProject($id){
        $project = $this->projectManager->find($id);
        return $project;
    }

    public function editProjectFiles(
                                $project_mainImage,
                                $project_images,
                                $project_documents,
                                $project

    ){
        if(isset($project_mainImage)){

            $this->fileProcessService->UploadMainImage($project_mainImage, $project);
        }

        if(isset($project_images)){

            //store the files in an array
            $uploadedFiles = array();
            foreach($project_images as $key => $project_image){
                array_push($uploadedFiles, $project_image);
            }

            //upload each of the file
            foreach($uploadedFiles as $key => $uploadedFile){
                $this->fileProcessService->UploadImage($uploadedFile, $project);
            }
        }

        if(isset($project_documents)){

            //store the files in an array
            $uploadedFiles = array();
            foreach($project_documents as $key => $project_document){
                array_push($uploadedFiles, $project_document);
            }

            //upload each of the file
            foreach($uploadedFiles as $key => $uploadedFile){
                $this->fileProcessService->UploadDocument($uploadedFile, $project);
            }
        }

        $this->projectManager->save($project);

        return $project;
    }

    public function getAllProjects(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $qb->select( 'p' )
            ->from( 'App\Entity\Project',  'p' )
            ->orderBy('p.project_creationdate', 'DESC');

        $projects = $qb->getQuery()->getResult();

        return  $projects;
    }

    public function setProjectStatus($project){
        if($project->getProjectPublish()){
            $project->setProjectPublish(False);
        }else{
            $project->setProjectPublish(True);
        }

        $this->projectManager->save($project);

        return $project;
    }

    public function getAllPublishProjectStats(){
        $publishedProjectStat = $this->getPublishProjectStat();
        $totalProjectStat = $this->getTotalProjectStat();
        $onFinanceProjectStat = $this->onFinanceProjectStat();
        $notFinancedProjectStat = $this->notFinancedProjectStat();
        $contributionPendingStat = $this->contributionPendingStat();

        return [
          "publishedProjectStat" => $publishedProjectStat,
          "totalProjectStat" => $totalProjectStat,
          "onFinanceProjectStat" => $onFinanceProjectStat,
          "notFinancedProjectStat" => $notFinancedProjectStat,
          "contributionPendingStat" => $contributionPendingStat
        ];
    }

    public function getPublishProjectStat(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $publishedProjectStat = $qb->select( 'count(p.id)' )
            ->from( 'App\Entity\Project',  'p' )
            ->where( 'p.publish = 1')
            ->orderBy('p.project_creationdate', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();

        return $publishedProjectStat;
    }

    public function getUnPublishProjectStat(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $unPublishedProjectStat = $qb->select( 'count(p.id)' )
            ->from( 'App\Entity\Project',  'p' )
            ->where( 'p.publish = 0')
            ->orderBy('p.project_creationdate', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();

        return $unPublishedProjectStat;
    }

    public function getTotalProjectStat(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $totalProjectStat = $qb->select( 'count(p.id)' )
            ->from( 'App\Entity\Project',  'p' )
            ->orderBy('p.project_creationdate', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();

        return $totalProjectStat;
    }

    public function onFinanceProjectStat(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $onFinanceProjectStat = $qb->select( 'count(p.id)' )
            ->from( 'App\Entity\Project',  'p' )
            ->where( 'p.Engaged != 0')
            ->orderBy('p.project_creationdate', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();

        return $onFinanceProjectStat;
    }

    public function notFinancedProjectStat(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $onFinanceProjectStat = $qb->select( 'count(p.id)' )
            ->from( 'App\Entity\Project',  'p' )
            ->where( 'p.Engaged = 0')
            ->orderBy('p.project_creationdate', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();

        return $onFinanceProjectStat;
    }

    public function getAllBankOrders(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $qb->select( 'u' )
            ->from( 'App\Entity\UserProject',  'u' )
            ->where('u.payment_method = :data' )
            ->orderBy('u.creationDate', 'DESC')
            ->setParameter('data','Virement bancaire');

        $orders = $qb->getQuery()->getResult();

        return  $orders;
    }

    public function contributionPendingStat(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $contributionPendingStat = $qb->select( 'count(p.id)' )
            ->from( 'App\Entity\UserProject',  'p' )
            ->where( 'p.status = :data' )
            ->orderBy('p.project_creationdate', 'DESC')
            ->setParameter('data','Pending')
            ->getQuery()
            ->getSingleScalarResult();

        return $contributionPendingStat;
    }
}