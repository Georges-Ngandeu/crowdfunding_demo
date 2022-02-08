<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 03/04/2020
 * Time: 16:36
 */

namespace App\Services;


use App\Entity\Admin;
use App\Entity\Manager;
use App\Entity\SubAdmin;
use App\Entity\User;
use App\Manager\AdminManager;
use App\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminService
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
    /**
     * @var AdminManager
     */
    private $adminManager;

    /**
     * AuthorService constructor.
     */
    public function __construct(UserManager $userManager,
                                AdminManager $adminManager,
                                UserManagerInterface $userManagerInterface,
                                EntityManagerInterface $entityManagerInterface,
                                FileProcessService $fileProcessService,
                                UserPasswordEncoderInterface $userPasswordEncoder,
                                TokenGeneratorInterface $tokenGenerator

    )
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->fileProcessService = $fileProcessService;
        $this->userManager = $userManager;
        $this->userManagerInterface = $userManagerInterface;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenGenerator = $tokenGenerator;
        $this->adminManager = $adminManager;
    }

    public function createAdmin($admin_firstname,
                                  $admin_lastname,
                                  $admin_phone,
                                  $admin_region,
                                  $admin_username,
                                  $admin_email,
                                  $admin_password
    ){

        $user = new User();
        $user->setUsername($admin_username);
        $user->setEmail($admin_email);
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $admin_password));
        $user->setUserType("Admin");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEnabled(True);

        $this->userManagerInterface->updateUser($user);

        $admin = new Admin();
        $admin->setAdminFirstname($admin_firstname);
        $admin->setAdminLastname($admin_lastname);
        $admin->setAdminPhone($admin_phone);
        $admin->setAdminRegion($admin_region);
        $admin->setUser($user);

        $this->entityManagerInterface->persist($admin);
        $this->entityManagerInterface->flush();

        return $admin;
    }

    public function getAllAdmins(){
        $qb = $this->entityManagerInterface->createQueryBuilder();

        $qb->select( 'a' )
            ->from( 'App\Entity\Admin',  'a' )
            ->orderBy('a.admin_createdat', 'DESC');

        $managers = $qb->getQuery()->getResult();

        return  $managers;
    }
}