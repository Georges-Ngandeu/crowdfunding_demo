<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 03/04/2020
 * Time: 16:36
 */

namespace App\Services;


use App\Entity\Manager;
use App\Entity\User;
use App\Manager\ManagerManager;
use App\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ManagerService
{
    /**
     * @var FileProcessService
     */
    private $fileProcessService;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var UserManagerInterface
     */
    private $userManagerInterface;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    private $managermanager;

    /**
     * AuthorService constructor.
     */
    public function __construct(UserManager $userManager,
                                UserManagerInterface $userManagerInterface,
                                EntityManagerInterface $entityManagerInterface,
                                FileProcessService $fileProcessService,
                                UserPasswordEncoderInterface $userPasswordEncoder,
                                TokenGeneratorInterface $tokenGenerator,
                                ManagerManager $managermanager

    )
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->fileProcessService = $fileProcessService;
        $this->userManager = $userManager;
        $this->userManagerInterface = $userManagerInterface;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenGenerator = $tokenGenerator;
        $this->managermanager = $managermanager;
    }

    public function createManager($manager_firstname,
                                  $manager_lastname,
                                  $manager_phone,
                                  $manager_region,
                                  $manager_username,
                                  $manager_email,
                                  $manager_password
                                  ){

        $user = new User();
        $user->setUsername($manager_username);
        $user->setEmail($manager_email);
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $manager_password));
        $user->setUserType("Manager");

        $this->userManagerInterface->updateUser($user);

        $manager = new Manager();
        $manager->setManagerFirstname($manager_firstname);
        $manager->setManagerLastname($manager_lastname);
        $manager->setManagerPhone($manager_phone);
        $manager->setManagerRegion($manager_region);
        $manager->setUser($user);

        $this->entityManagerInterface->persist($manager);
        $this->entityManagerInterface->flush();

        return $manager;
    }

    public function getAllManagers(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $qb->select( 'm' )
            ->from( 'App\Entity\Manager',  'm' )
            ->orderBy('m.manager_createdat', 'DESC');

        $managers = $qb->getQuery()->getResult();

        return  $managers;
    }

    public function getMinSubsManager() : Manager
    {
        $criteria = array();
        $order = array("manager_count_subscription" => "ASC");
        $managers = $this->managermanager->findBy($criteria, $order);
        return $managers[0];
    }
}