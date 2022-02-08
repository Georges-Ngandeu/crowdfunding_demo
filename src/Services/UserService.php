<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 21/08/2020
 * Time: 07:32
 */

namespace App\Services;


use App\Entity\Subscriber;
use App\Entity\User;
use App\Manager\SubscriberManager;
use App\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var UserManagerInterface
     */
    private $userManagerInterface;
    /**
     * @var EntityManagerInterface
     */
    private $entityManagerInterface;
    /**
     * @var FileProcessService
     */
    private $fileProcessService;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;
    /**
     * @var SubscriberManager
     */
    private $subscriberManager;

    /**
     * UserService constructor.
     */
    public function __construct(
        UserManager $userManager,
        UserManagerInterface $userManagerInterface,
        EntityManagerInterface $entityManagerInterface,
        FileProcessService $fileProcessService,
        UserPasswordEncoderInterface $userPasswordEncoder,
        TokenGeneratorInterface $tokenGenerator,
        SubscriberManager $subscriberManager
    )
    {
        $this->userManager = $userManager;
        $this->userManagerInterface = $userManagerInterface;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->fileProcessService = $fileProcessService;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenGenerator = $tokenGenerator;
        $this->subscriberManager = $subscriberManager;
    }

    public function createUser(
        $moralePersonName,
        $moralePersonRepresentant,
        $subscriberFirstName,
        $subscriberLastName,
        $subscriberBirthDate,
        $subscriberBirthPlace,
        $subscriberCniNumber,
        $subscriberCniDate,
        $subscriberCniPlace,
        $subscriberPhone,
        $subscriberPhone2,
        $subscriberEmail,
        $subscriberProfession,
        $subscriberTown,
        $subscriberMaritalStatus,
        $subscriberProfessionalStatus,
        $subscriberRevenuEstimate,
        $subscriberRevenuOrigin,
        $subscriberOtherRevenuOrigin,
        $subscriberNationality,
        $subscriberGender,
        $moralePersonRepresentantLastname,
        $country,
        $region,
        $subscriberLanguage
    ){
        $user = new User();

        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $subscriberEmail));
        $user->setEnabled(1);
        $user->setUsername($subscriberFirstName);
        $user->setEmail($subscriberEmail);
        $user->setRoles(["ROLE_SUBSCRIBER"]);
        //$user->setConfirmationToken($this->tokenGenerator->generateToken());

        $this->userManagerInterface->updateUser($user);

        $subscriber = new Subscriber();

        $subscriber->setSubscriberFirstname($subscriberFirstName);
        $subscriber->setSubscriberLastname($subscriberLastName);
        $subscriber->setSubscriberEnterpriseName($moralePersonName);
        $subscriber->setSubscriberDirectorFirstname($moralePersonRepresentant);
        $subscriber->setSubscriberDirectorLastname($moralePersonRepresentantLastname);
        $subscriber->setSubscriberBirthdate($subscriberBirthDate);
        $subscriber->setSubscriberBirthPlace($subscriberBirthPlace);
        $subscriber->setSubscriberIdentityCardNumber($subscriberCniNumber);
        $subscriber->setSubscriberIdentityCardDeliveryDate($subscriberCniDate);
        $subscriber->setSubscriberIdentityCardDeliveryPlace($subscriberCniPlace);
        $subscriber->setSubscriberTelephone($subscriberPhone);
        $subscriber->setSubscriberOtherTelephone($subscriberPhone2);
        $subscriber->setSubscriberProfession($subscriberProfession);
        $subscriber->setSubscriberTown($subscriberTown);
        $subscriber->setSubscriberMaritalStatus($subscriberMaritalStatus);
        $subscriber->setSubscriberProfessionalStatus($subscriberProfessionalStatus);
        $subscriber->setSubscriberRevenu($subscriberRevenuEstimate);
        $subscriber->setSubscriberRevenuOrigine($subscriberRevenuOrigin);
        $subscriber->setSubscriberOtherRevenuOrigin($subscriberOtherRevenuOrigin);
        $subscriber->setSubscriberUsername($subscriberFirstName);
        $subscriber->setSubscriberEmail($subscriberEmail);
        $subscriber->setSubscriberNationality($subscriberNationality);
        $subscriber->setSubscriberGender($subscriberGender);
        $subscriber->setSubscriberCountry($country);
        $subscriber->setSubscriberRegion($region);
        $subscriber->setSubscriberLanguage($subscriberLanguage);

//        if(isset($user_subscriber_image)){
//
//            $this->fileProcessService->UploadSubscriberImage($user_subscriber_image, $subscriber);
//        }

        $subscriber->setUser($user);
        $this->entityManagerInterface->persist($subscriber);
        $this->entityManagerInterface->flush();

        return $subscriber;
    }

    public function userEmailValidation($user){
        $user->setEnabled(1);
        $this->userManager->save($user);
        return $user;
    }

    public function getUser($id){
        $user = $this->userManager->find($id);
        return $user;
    }

    public function registerEngagement($subscriber, $project, $subscriberProject){
        //dump($subscriberProject);die;
        $subscriber->addSubscriberProject($subscriberProject);
        $project->addProjectSubscriber($subscriberProject);

        $this->entityManagerInterface->persist($subscriberProject);
        $this->entityManagerInterface->flush();
        //$this->subscriberManager->save($subscriber[0]);
        return $subscriberProject;
    }

    public function checkSubscriberInSystem($subscriber_email){
        return $this->subscriberManager->findBy(["subscriber_email" => $subscriber_email]);
    }

    public function getSubscriber($id){
        return $this->subscriberManager->find($id);
    }

}