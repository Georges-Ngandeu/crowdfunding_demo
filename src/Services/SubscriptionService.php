<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 22/04/2020
 * Time: 09:18
 */

namespace App\Services;

use App\Entity\Manager;
use App\Entity\SubscriberProject;
use App\Events\ContributionSucceedEvent;
use App\Events\NotifyContributorEvent;
use App\Manager\ProjectManager;
use App\Manager\SubscriberProjectManager;
use App\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class SubscriptionService
{
    /**
     * @var UserManager
     */
    private $userManager;
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
     * @var UserManagerInterface
     */
    private $theUserManager;
    /**
     * @var SubscriberProjectManager
     */
    private $subscriberProjectManager;

    private $managerService;

    private $pdfService;

    private $mailService;

    private $params;

    /**
     * ContributorServices constructor.
     */
    public function __construct(UserManager $userManager,
                                ProjectManager $projectManager,
                                EntityManagerInterface $entityManagerInterface,
                                EventDispatcherInterface $eventDispatcher,
                                FileProcessService $fileProcessService,
                                UserManagerInterface $theUserManager,
                                SubscriberProjectManager $subscriberProjectManager,
                                ManagerService $managerService,
                                PdfService $pdfService,
                                MailService $mailService,
                                ContainerBagInterface $params)
    {
        $this->userManager = $userManager;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->projectManager = $projectManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->fileProcessService = $fileProcessService;
        $this->theUserManager = $theUserManager;
        $this->subscriberProjectManager = $subscriberProjectManager;
        $this->managerService = $managerService;
        $this->pdfService = $pdfService;
        $this->mailService = $mailService;
        $this->params = $params;
    }

    public function getAllContributors(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $qb->select( 'u' )
            ->from( 'App\Entity\User',  'u' )
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"ROLE_SUBSCRIBER_USER"%');

        $contributors = $qb->getQuery()->getResult();

        return  $contributors ;
    }

    public function setContributorStatus($contributor){
        if($contributor->isEnabled()){
            $contributor->setEnabled(False);
        }else{
            $contributor->setEnabled(True);
        }

        $this->userManager->save($contributor);

        return $contributor;
    }

    public function getContributor($id){
        $contributor = $this->userManager->find($id);
        return $contributor;
    }

    public function registerContribution($user,
                                         $project,
                                         $userProject){
        $user->addContributor($userProject);
        $project->addContributorProject($userProject);
        $this->userManager->save($user);
    }

    public function saveContribution($user, $project, $upId, $phone, $amount){

        $userProject = $this->userProjectManager->find($upId);
        $userProject->setStatus('Success');
        $userProject->setPhone($phone);
        $userProject->setAmount($amount);
        $this->userProjectManager->save($userProject);

        $project = $this->projectManager->find($userProject->getProjects()->getId());

        $project->setEngaged($project->getEngaged() + $userProject->getAmount());
        $project->setNumberContributions($project->getNumberContributions() + 1);
        $this->projectManager->save($project);

        $contributionSucceedEvent = new ContributionSucceedEvent($project);

        $this->eventDispatcher->dispatch(ContributionSucceedEvent::NAME, $contributionSucceedEvent);

        $notifyContributorEvent = new NotifyContributorEvent($user, $project);

        $this->eventDispatcher->dispatch(NotifyContributorEvent::NAME, $notifyContributorEvent);
    }

    public function validateContribution($id){

        $userProject = $this->userProjectManager->find($id);
        $userProject->setStatus("Validated");
        $project = $this->projectManager->find($userProject->getProjects()->getId());

        $project->setEngaged($project->getEngaged() + $userProject->getAmount());
        $project->setNumberContributions($project->getNumberContributions() + 1);
        $this->projectManager->save($project);
    }

    public function registerBankReceipt($user, $project, $userProject, $bank_receipt ){
        $this->userProjectManager->save($userProject);
        $this->fileProcessService->UploadBankReceipt($bank_receipt, $project, $userProject);
    }

    public function contributionDetail($id){

        $query = $this->entityManagerInterface->createQuery(
            'SELECT up
                  FROM App\Entity\UserProject up
                  JOIN up.projects p
                  WHERE p.id = :id
                  '
        );
        $query->setParameter("id", $id);
        $result = $query->getResult();
        return  $result;
    }

    public function userEmailValidation($user){
        $user->setEnabled(1);
        $this->userManager->save($user);
        return $user;
    }

    public function getAllRequest(){

//        $result = $this->userProjectManager->findBy(
//            ['status' => 'Success']
//        );
//        return $result;

        $query = $this->entityManagerInterface->createQuery(
            'SELECT sp
                  FROM App\Entity\SubscriberProject sp
                  '
        );

        $result = $query->getResult();
        return  $result;
    }

    public function registerEngagement($user, $project, $userProject){
        $user->addContributor($userProject);
        $project->addContributorProject($userProject);
        $this->userManager->save($user);
    }

    public function validateRequest($id){
        $subscription = $this->subscriberProjectManager->find($id);

        $subscription->setSubscriptionStatus(True);
        $this->subscriberProjectManager->save($subscription);

        return $subscription;
    }

    public function checkContributionRight($uid, $pid){
        $query = $this->entityManagerInterface->createQuery(
            'SELECT up
                  FROM App\Entity\UserProject up
                  JOIN up.projects p
                  JOIN up.contributors u
                  WHERE u.id = :uid AND p.id = :pid AND up.canContribute = TRUE
                  '
        );
        $query->setParameter("uid", $uid);
        $query->setParameter("pid", $pid);
        $result = $query->getResult();
        return  $result;
    }

    public function rejectRequest($id){
        $subscription = $this->subscriberProjectManager->find($id);

        $subscription->setSubscriptionStatus(False);
        $this->subscriberProjectManager->save($subscription);

        return $subscription;
    }


    public function allowToManager(SubscriberProject $subscriberProject) : SubscriberProject
    {
        //Get Manager with low count subscription
        $manager = $this->managerService->getMinSubsManager();
        $manager->setManagerCountSubscription($manager->getManagerCountSubscription() + 1);
        $subscriberProject->setManagerId($manager);
        $subscriberProject = $this->subscriberProjectManager->save($subscriberProject);
        // Get subscribe file
        $file_subscribe_name =  $this->params->get("kernel.project_dir"). "/public/subscription/subscription". $subscriberProject->getId() .".pdf";
        //Get contract file
        $file_contract_name = $this->params->get("kernel.project_dir"). "/public/contract/contract". $subscriberProject->getId() .".pdf";
        $this->mailService->full("CRIFAT", [$manager->getManagerEmail()], "Assignation à une souscription", "", null, [$file_subscribe_name, $file_contract_name]);
        //dump($manager->getManagerEmail()); 
        //$this->mailService->send("Crifat", [$manager->getManagerEmail()], "Tses", "Test");
        //die;
        return $subscriberProject;
    }
   

}