<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Subscriber;
use App\Entity\SubscriberProject;
use App\Events\EmailValidationEvent;
use App\Events\EngagementSentEvent;
use App\Events\UserRegisterEvent;
use App\Exception\OtpException;
use App\Form\AfrikpayPaymentFormType;
use App\Form\BankReceiptFormType;
use App\Form\EngageFormType;
use App\Form\EngagementFormType;
use App\Form\MtnPaymentFormType;
use App\Form\OmPaymentFormType;
use App\Form\PaymentConfirmFormType;
use App\Form\ResetPasswordFormType;
use App\Form\EumPaymentFormType;
use App\Form\UserFormType;
use App\Form\UserLoginFormType;
use App\Manager\SubscriberManager;
use App\Manager\SubscriberProjectManager;
use App\Manager\UserManager;
use App\Services\FileProcessService;
use App\Services\OtpService;
use App\Services\ProjectService;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class HomeController extends AbstractController
{
    /**
     * @var ProjectService
     */
    private $projectService;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var Security
     */
    private $security;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var SubscriberManager
     */
    private $subscriberManager;
    /**
     * @var SubscriberProjectManager
     */
    private $subscriberProjectManager;
    /**
     * @var FileProcessService
     */
    private $fileProcessService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * HomeController constructor.
     */
    public function __construct(ProjectService $projectService,
                                FormFactoryInterface $formFactory,
                                Security $security,
                                EventDispatcherInterface $eventDispatcher,
                                UserManager $userManager,
                                UserService $userService,
                                UserPasswordEncoderInterface $userPasswordEncoder,
                                RouterInterface $router,
                                SubscriberManager $subscriberManager,
                                SubscriberProjectManager $subscriberProjectManager,
                                FileProcessService $fileProcessService,
                                EntityManagerInterface $entityManager)
    {
        $this->projectService = $projectService;
        $this->formFactory = $formFactory;
        $this->security = $security;
        $this->eventDispatcher = $eventDispatcher;
        $this->userManager = $userManager;
        $this->userService = $userService;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->router = $router;
        $this->subscriberManager = $subscriberManager;
        $this->subscriberProjectManager = $subscriberProjectManager;
        $this->fileProcessService = $fileProcessService;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        $projects = $this->projectService->getAllPublishedProjects();
        return $this->render('home/home2.html.twig', [
            'controller_name' => 'HomeController',
            "projects" => $projects
        ]);
    }


    /**
     * @Route("/detail/{id}", options={"expose"=true}, name="detail")
     */
    public function detail(Request $request, $id)
    {
        $form2 = $this->formFactory->create(UserFormType::class);
        $form1 = $this->formFactory->create(UserLoginFormType::class);
        $form1->handleRequest($request);

        $userId = $request->get("userId");

        $package = new Package(new EmptyVersionStrategy());

        $project = $this->projectService->getProject($id);

        return $this->render('home/detail.html.twig', [
            'controller_name' => 'HomeController',
            "project" => $project,
            "package" => $package,
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'userId' =>  $userId
        ]);
    }


    /**
     * @Route("/detail/{id}/v1", name="detailV1")
     */
    public function detailV1(Request $request, $id)
    {
        $form2 = $this->formFactory->create(UserFormType::class);
        $form1 = $this->formFactory->create(UserLoginFormType::class);
        $form1->handleRequest($request);

        if ($request->isMethod('POST')) {

            $user_username = $form1->get('username')->getData();
            $user_password = $form1->get('password')->getData();

            if ($form1->isSubmitted() && $form1->isValid()) {

                //$user = $this->userManager->findUserByUsername($user_username);
                $user = $this->userManager->findOneBy(["email" => $user_username]);

                if(!$user){
                    return $this->redirectToRoute('loginUser');
                }

                if( !($this->userPasswordEncoder->isPasswordValid($user, $user_password))){
                    return $this->redirectToRoute('loginUser');
                }

                $token = new UsernamePasswordToken($user, $user->getPassword(), "main", $user->getRoles());
                $this->get("security.token_storage")->setToken($token);

                $event = new InteractiveLoginEvent($request, $token);

                $this->eventDispatcher->dispatch($event);

                $form = $this->formFactory->create(EngageFormType::class);
                $form->handleRequest($request);

                return $this->redirectToRoute('projectEngagement', array(
                    "id" => $id,
                ));
            }
        }

        $package = new Package(new EmptyVersionStrategy());

        $project = $this->projectService->getProject($id);

        $user = $this->security->getUser();
        $checkContributionRight = [];

        if($user){
            $uid = $user->getId();
            $pid = $id;
            //$checkContributionRight = $this->contributorService->checkContributionRight($uid, $pid);
        }

        //dump($checkContributionRight); die;

        return $this->render('home/detail.html.twig', [
            'controller_name' => 'HomeController',
            "project" => $project,
            "package" => $package,
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            //'contributionRight' => $checkContributionRight
        ]);
    }

    /**
     * @Route("/login/user", name="loginUser")
     */
    public function login(Request $request){

        $form = $this->formFactory->create(UserLoginFormType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $user_username = $form->get('username')->getData();
            $user_password = $form->get('password')->getData();

            if ($form->isSubmitted() && $form->isValid()) {

                //$user = $this->userManager->findUserByUsername($user_username);
                $user = $this->userManager->findOneBy(["email" => $user_username]);

                if(!$user){
                    $errors = ["Utilisateur introuvable"];
                    return $this->render('home/login.html.twig', [
                        'form' => $form->createView(),
                        'errors' => $errors
                    ]);
                }

                if ($user->isEnabled() == false) {
                    $errors = ["Email non validé"];
                    return $this->render('home/login.html.twig', [
                        'form' => $form->createView(),
                        'errors' => $errors
                    ]);
                }

                if( !($this->userPasswordEncoder->isPasswordValid($user, $user_password))){
                    $errors = ["Mot de passe invalide"];
                    return $this->render('home/login.html.twig', [
                        'form' => $form->createView(),
                        'errors' => $errors
                    ]);
                }

                $token = new UsernamePasswordToken($user, $user->getPassword(), "main", $user->getRoles());
                $this->get("security.token_storage")->setToken($token);

                $event = new InteractiveLoginEvent($request, $token);

                $this->eventDispatcher->dispatch($event);

                $targetPath = $user->getSessionStore();
                $url = $this->router->generate('home');

                if ($targetPath) {
                    $url = $targetPath;
                }

                return new RedirectResponse($url);

                //return $this->redirectToRoute('home');
            }
        }

        return $this->render('home/login.html.twig', [
            'form' => $form->createView(),
            'errors' => []
        ]);
    }

    /**
     * @Route("/test/strange", name="testStrange")
     */
    public function TestStrangeBehaviour(){
        $registeredUser = $this->userManager->findBy(["email" => "jojo@gmail.com"]);

        dump($registeredUser);die;

        if(isset($registeredUser)){
            return new JsonResponse([
                'Result' => "User has an account",
            ]);
        }
    }

    /**
     * @Rest\Post(
     *    path = "/api/test/post",
     *    name = "apiTestPost"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function apiTestPost(Request $request)
    {
        $content = $request->getContent();
        $result = json_decode($content);

        $response = new Response();
        $response->setContent(json_encode([
            'data1' => $result->data1,
            'data2' => $result->data2,
        ]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Rest\Get(
     *    path = "/api/test/get",
     *    name = "apiTestGet"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function apiTestGet(Request $request ){
        $response = new Response();
        $response->setContent(json_encode([
            'data' => 123,
        ]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Rest\Post(
     *    path = "/ajax/register/user",
     *     options={"expose"=true},
     *    name = "registerUserPost"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function registerUserPost(Request $request)
    {
        $content = $request->getContent();
        $decodedContent = json_decode($content);

        $moralePersonName = $decodedContent->moralePersonName;
        $moralePersonRepresentant = $decodedContent->moralePersonRepresentant;
        $subscriberFirstName = $decodedContent->subscriberFirstName;
        $subscriberLastName = $decodedContent->subscriberLastName;
        $subscriberBirthDate = $decodedContent->subscriberBirthDate;
        $subscriberBirthPlace = $decodedContent->subscriberBirthPlace;
        $subscriberCniNumber = $decodedContent->subscriberCniNumber;
        $subscriberCniDate = $decodedContent->subscriberCniDate;
        $subscriberCniPlace = $decodedContent->subscriberCniPlace;
        $subscriberPhone = $decodedContent->subscriberPhone;
        $subscriberPhone2 = $decodedContent->subscriberPhone2;
        $subscriberEmail = $decodedContent->subscriberEmail;
        $subscriberProfession = $decodedContent->subscriberProfession;
        $subscriberTown = $decodedContent->subscriberTown;
        $subscriberMaritalStatus = $decodedContent->subscriberMaritalStatus;
        $subscriberProfessionalStatus = $decodedContent->subscriberProfessionalStatus;
        $subscriberRevenuEstimate = $decodedContent->subscriberRevenuEstimate;
        $subscriberRevenuOrigin = $decodedContent->subscriberRevenuOrigin;
        $subscriberOtherRevenuOrigin = $decodedContent->subscriberOtherRevenuOrigin;
        $subscriberNationality = $decodedContent->subscriberNationality;
        $subscriberGender = $decodedContent->subscriberGender;
        $moralePersonRepresentantLastname = $decodedContent->moralePersonRepresentantLastname;
        $country = $decodedContent->country;
        $region = $decodedContent->region;
        $subscriberLanguage = $decodedContent->subscriberLanguage;

        $subscriber = $this->userService->createUser(
            $moralePersonName,
            $moralePersonRepresentant,
            $subscriberFirstName,
            $subscriberLastName,
            //new \DateTime('@'.strtotime($subscriberBirthDate)),
            new \DateTime('@'.strtotime(explode( 'T', $subscriberBirthDate)[0])),
            $subscriberBirthPlace,
            $subscriberCniNumber,
            //new \DateTime('@'.strtotime($subscriberCniDate)),
            new \DateTime('@'.strtotime(explode( 'T', $subscriberCniDate)[0])),
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
        );

        //$emailValidationEvent = new EmailValidationEvent($subscriber);
        //$this->eventDispatcher->dispatch(EmailValidationEvent::NAME, $emailValidationEvent);

        $userRegisterEvent = new UserRegisterEvent($subscriber);
        $this->eventDispatcher->dispatch(UserRegisterEvent::NAME, $userRegisterEvent);

        return new JsonResponse([
            'userData' => [
                'moralePersonName' => $moralePersonName,
                'moralePersonRepresentant' => $moralePersonRepresentant,
                'subscriberFirstName' => $subscriberFirstName,
                'subscriberLastName' => $subscriberLastName,
                'subscriberBirthDate' => explode( 'T', $subscriberBirthDate)[0],
                'subscriberBirthPlace' => $subscriberBirthPlace,
                'subscriberCniNumber' => $subscriberCniNumber,
                'subscriberCniDate' => explode( 'T', $subscriberCniDate)[0],
                'subscriberCniPlace' => $subscriberCniPlace,
                'subscriberPhone' => $subscriberPhone,
                'subscriberPhone2' => $subscriberPhone2,
                'subscriberEmail' => $subscriberEmail,
                'subscriberProfession' => $subscriberProfession,
                'subscriberTown' => $subscriberTown,
                'subscriberMaritalStatus' => $subscriberMaritalStatus,
                'subscriberProfessionalStatus' => $subscriberProfessionalStatus,
                'subscriberRevenuEstimate' => $subscriberRevenuEstimate,
                'subscriberRevenuOrigin' => $subscriberRevenuOrigin,
                'subscriberNationality' => $subscriberNationality,
                'subscriberGender' => $subscriberGender,
                'moralePersonRepresentantLastname' => $moralePersonRepresentantLastname,
                'country' => $country,
                'region' => $region,
                'subscriberLanguage' => $subscriberLanguage
            ],
            'userId' => $subscriber->getId()
        ]);
    }

    /**
     * @Rest\Post(
     *    path = "/ajax/user/photo/{id}",
     *     options={"expose"=true},
     *    name = "registerUserPhotoPost"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function registerUserPhotoPost(Request $request)
    {
        $id = $request->get('id');
        $imageFile = $request->files->get('file');

        $subscriber =  $this->subscriberManager->find($id);
        if(isset($imageFile)){
            $this->fileProcessService->UploadSubscriberImage($imageFile, $subscriber);
            $this->entityManager->persist($subscriber);
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'Result' => 'User photo uploaded!',
            'stats' => True
        ]);
    }


    /**
     * @Route("/register/user/{id}", options={"expose"=true}, name="registerUser")
     */
    public function registerUser(Request $request)
    {
        $id = $request->get('id');

        $project = $this->projectService->getProject($id);

        if ($request->isMethod('POST')) {

            $moralePersonName = $request->get('moralePersonName');
            $moralePersonRepresentant = $request->get('moralePersonRepresentant');
            $subscriberFirstName = $request->get('subscriberFirstName');
            $subscriberLastName = $request->get('subscriberLastName');
            $subscriberBirthDate = $request->get('subscriberBirthDate');
            $subscriberBirthPlace = $request->get('subscriberBirthPlace');
            $subscriberCniNumber = $request->get('subscriberCniNumber');
            $subscriberCniDate = $request->get('subscriberCniDate');
            $subscriberCniPlace = $request->get('subscriberCniPlace');
            $subscriberPhone = $request->get('subscriberPhone');
            $subscriberEmail = $request->get('subscriberEmail');
            $subscriberProfession = $request->get('subscriberProfession');
            $subscriberTown = $request->get('subscriberTown');
            $subscriberMaritalStatus = $request->get('subscriberMaritalStatus');
            $subscriberProfessionalStatus = $request->get('subscriberProfessionalStatus');
            $subscriberRevenuEstimate = $request->get('subscriberRevenuEstimate');
            $subscriberRevenuOrigin = $request->get('subscriberRevenuOrigin');

            return new JsonResponse([
                'userData' => [
                    'moralePersonName' => $moralePersonName,
                    'moralePersonRepresentant' => $moralePersonRepresentant,
                    'subscriberFirstName' => $subscriberFirstName,
                    'subscriberLastName' => $subscriberLastName,
                    'subscriberBirthDate' => explode( 'T', $subscriberBirthDate)[0],
                    'subscriberBirthPlace' => $subscriberBirthPlace,
                    'subscriberCniNumber' => $subscriberCniNumber,
                    'subscriberCniDate' => explode( 'T', $subscriberCniDate)[0],
                    'subscriberCniPlace' => $subscriberCniPlace,
                    'subscriberPhone' => $subscriberPhone,
                    'subscriberEmail' => $subscriberEmail,
                    'subscriberProfession' => $subscriberProfession,
                    'subscriberTown' => $subscriberTown,
                    'subscriberMaritalStatus' => $subscriberMaritalStatus,
                    'subscriberProfessionalStatus' => $subscriberProfessionalStatus,
                    'subscriberRevenuEstimate' => $subscriberRevenuEstimate,
                    'subscriberRevenuOrigin' => $subscriberRevenuOrigin
                ],
                'userId' => "userId",
            ]);

            $this->userService->createUser(
                $moralePersonName,
                $moralePersonRepresentant,
                $subscriberFirstName,
                $subscriberLastName,
                //new \DateTime('@'.strtotime($subscriberBirthDate)),
                new \DateTime('@'.strtotime('now')),
                $subscriberBirthPlace,
                $subscriberCniNumber,
                //new \DateTime('@'.strtotime($subscriberCniDate)),
                new \DateTime('@'.strtotime('now')),
                $subscriberCniPlace,
                $subscriberPhone,
                $subscriberEmail,
                $subscriberProfession,
                $subscriberTown,
                $subscriberMaritalStatus,
                $subscriberProfessionalStatus,
                $subscriberRevenuEstimate,
                $subscriberRevenuOrigin
            );

//            $emailValidationEvent = new EmailValidationEvent($subscriber);
//            $this->eventDispatcher->dispatch(EmailValidationEvent::NAME, $emailValidationEvent);
//
//            $userRegisterEvent = new UserRegisterEvent($subscriber);
//            $this->eventDispatcher->dispatch(UserRegisterEvent::NAME, $userRegisterEvent);

            return new JsonResponse([
                'userData' => [
                    'moralePersonName' => $moralePersonName,
                    'moralePersonRepresentant' => $moralePersonRepresentant,
                    'subscriberFirstName' => $subscriberFirstName,
                    'subscriberLastName' => $subscriberLastName,
                    'subscriberBirthDate' => $subscriberBirthDate,
                    'subscriberBirthPlace' => $subscriberBirthPlace,
                    'subscriberCniNumber' => $subscriberCniNumber,
                    'subscriberCniDate' => $subscriberCniDate,
                    'subscriberCniPlace' => $subscriberCniPlace,
                    'subscriberPhone' => $subscriberPhone,
                    'subscriberEmail' => $subscriberEmail,
                    'subscriberProfession' => $subscriberProfession,
                    'subscriberTown' => $subscriberTown,
                    'subscriberMaritalStatus' => $subscriberMaritalStatus,
                    'subscriberProfessionalStatus' => $subscriberProfessionalStatus,
                    'subscriberRevenuEstimate' => $subscriberRevenuEstimate,
                    'subscriberRevenuOrigin' => $subscriberRevenuOrigin
                ],
                'userId' => "userId",
            ]);

        }

        return $this->render('home/register.html.twig', [
            'project' => $project
        ]);
    }

    /**
     * @Route("/register/user/v1", name="registerUserV1")
     */
    public function registerUserV1(Request $request)
    {
        $form = $this->formFactory->create(UserFormType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            //dump($form); die;
            $user_civility = $form->get('civility')->getData();
            $user_firstname = $form->get('firstname')->getData();
            $user_lastname = $form->get('lastname')->getData();
            $enterprise_name = $form->get('enterprise')->getData();
            $director_firstname = $form->get('director_firstname')->getData();
            $director_lastname = $form->get('director_lastname')->getData();
            $user_birthdate = $form->get('birthdate')->getData();
            $user_birth_place = $form->get('birth_place')->getData();
            $user_identity_card_number = $form->get('identity_card_number')->getData();
            $user_identitycard_deliver_date = $form->get('identitycard_deliver_date')->getData();
            $user_identitycard_deliver_place = $form->get('identitycard_deliver_place')->getData();
            $user_telephone = $form->get('telephone')->getData();
            $user_email = $form->get('email')->getData();
            $user_profession = $form->get('profession')->getData();
            $user_town = $form->get('town')->getData();
            $user_marital_status = $form->get('marital_status')->getData();
            $user_professional_status = $form->get('professional_status')->getData();
            $user_revenu = $form->get('revenu')->getData();
            $user_revenu_origine = $form->get('revenu_origine')->getData();
            $user_subscriber_image = $form->get('subscriber_image')->getData();
            $user_language = $form->get('language')->getData();
            $user_username = $form->get('username')->getData();
            $user_password = $form->get('password')->getData();

            if ($form->isSubmitted() && $form->isValid()) {

                //dump($form); die;
                $subscriber = $this->userService->createUser(
                    $user_civility,
                    $user_firstname,
                    $user_lastname,
                    $enterprise_name,
                    $director_firstname,
                    $director_lastname,
                    $user_birthdate,
                    $user_birth_place,
                    $user_identity_card_number,
                    $user_identitycard_deliver_date,
                    $user_identitycard_deliver_place,
                    $user_telephone,
                    $user_email,
                    $user_profession,
                    $user_town,
                    $user_marital_status,
                    $user_professional_status,
                    $user_revenu,
                    $user_revenu_origine,
                    $user_subscriber_image,
                    $user_language,
                    $user_username,
                    $user_password
                );

                $emailValidationEvent = new EmailValidationEvent($subscriber);
                $this->eventDispatcher->dispatch(EmailValidationEvent::NAME, $emailValidationEvent);

                $userRegisterEvent = new UserRegisterEvent($subscriber);
                $this->eventDispatcher->dispatch(UserRegisterEvent::NAME, $userRegisterEvent);

                return $this->render('home/registerSucceed.html.twig');
            }
        }

        return $this->render('home/register.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/subscriber/email/validation/{token}/{id}", name="userEmailValidation")
     */
    public function userEmailValidation($token, $id){

        $user = $this->userService->getUser($id);
        if( $token === $user->getConfirmationToken()){
            $this->userService->userEmailValidation($user);
            return $this->redirectToRoute('loginUser');
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/all", name="all")
     */
    public function all()
    {
        $projects = $this->projectService->getAllProjects();
        return $this->render('home/all.html.twig', [
            'controller_name' => 'HomeController',
            'projects' =>  $projects
        ]);
    }

    public function some_test(){
        $subscriber = new Subscriber();
        $subscriber->getUser()->getId();
        $subscriber->addSubscriberProject();
        $project = new Project();
        $project->getId();
        $project->addProjectSubscriber();
        $subscriberproject = new SubscriberProject();
        $subscriberproject->getSubscriberId()->getSubscriberBirthPlace();
        $subscriberproject->getProjectId()->getProjectCost();
        $subscriberproject->getSubscriberId()->getSubscriberGender();
        $subscriberproject->getSubscriptionPartner(["subscription_partner_firstname"]);
    }

    /**
     * @Route("/user/password/reset", name="resetPassword")
     */
    public function resetPassword(Request $request)
    {
        $form = $this->formFactory->create(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $admin_password = $form->get('password')->getData();
            $old_password = $form->get('old_password')->getData();

            $user = $this->security->getUser();

            $passwordStatus = $this->userPasswordEncoder->isPasswordValid($user, $old_password);

            if ($form->isSubmitted() && $form->isValid() && $passwordStatus) {

                $user->setPassword( $this->userPasswordEncoder->encodePassword($user, $admin_password));
                $this->userManager->updateUser($user);

                $this->addFlash('success', 'Votre mot de passe été modifié avec succès');
                return $this->redirectToRoute('home');
            }
        }

        return $this->render('home/resetPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/project/engagement/{id}", name="projectEngagement")
     */
    public function projectEngagement(Request $request, $id){

        $userId = $request->get("userId");
        $project = $this->projectService->getProject($id);

        return $this->render('home/engagementForm.html.twig', [
            'project' => $project,
            'userId' => $userId
        ]);
    }


    /**
     * @Route("/user/project/engagement/v1/{id}", name="projectEngagementV1")
     */
    public function projectEngagementV1(Request $request, $id){

        $form = $this->formFactory->create(EngagementFormType::class);
        $form->handleRequest($request);

        $project = $this->projectService->getProject($id);

        $user = $this->security->getUser();
        $subscriber = $this->subscriberManager->findBy(["subscriber_username" => $user->getUsername()]);

        if ($request->isMethod('POST')) {

            $subscription_partner_option = $form->get('subscription_partner_option')->getData();
            $subscription_partner_firstname = $form->get('subscription_partner_firstname')->getData();
            $subscription_partner_lastname = $form->get('subscription_partner_lastname')->getData();
            $subscription_partner_phone = $form->get('subscription_partner_phone')->getData();
            $subscription_partner_email = $form->get('subscription_partner_email')->getData();
            $subscription_number = $form->get('subscription_number')->getData();
            $subscription_mobile_operator = $form->get('subscription_mobile_operator')->getData();
            $subscription_mobile_account = $form->get('subscription_mobile_account')->getData();
            $subscription_campaign_awareness = $form->get('subscription_campaign_awareness')->getData();

            if ($form->isSubmitted() && $form->isValid() && $subscription_number >= $project->getProjectMinnumberaction()) {

                //dump($form);die;
                $user = $this->security->getUser();

                $subscriberProject = new SubscriberProject();
                $subscriberProject->setSubscriptionMobileAccount([
                    "subscription_partner_firstname" => $subscription_partner_firstname,
                    "subscription_partner_lastname" => $subscription_partner_lastname,
                    "subscription_partner_phone" => $subscription_partner_phone,
                    "subscription_partner_email" => $subscription_partner_email
                ]);
                $subscriberProject->setSubscriptionNumber($subscription_number);
                $subscriberProject->setSubscriptionCampaignAwareness($subscription_campaign_awareness);
                $subscriberProject->setSubscriptionMobileOperator($subscription_mobile_operator);
                $subscriberProject->setSubscriptionPartnerOption($subscription_partner_option);

                //$userProject->setStatus("Pending");
                $user = $this->security->getUser();
                $subscriber = $this->subscriberManager->findBy(["subscriber_username" => $user->getUsername()]);

                $updatedSubscriberProject = $this->userService->registerEngagement($subscriber,
                    $project,
                    $subscriberProject
                );

                $masterAdmin = $this->userManager->findBy(["username" => "admin"]);

                $engagementSentEvent = new EngagementSentEvent($subscriberProject);
                $this->eventDispatcher->dispatch(EngagementSentEvent::NAME, $engagementSentEvent);

                return $this->redirectToRoute('subscriptionSummary', [
                    "id" => $updatedSubscriberProject->getId()
                ]);
            }
        }

        $project = $this->projectService->getProject($id);

        return $this->render('home/engagementForm.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
            'subscriber' => $subscriber
        ]);
    }


    /**
     * @Route("/subscription/summary/{id}", options={"expose"=true}, name="subscriptionSummary")
     */
    public function subscriptionSummary($id){
        $subscription = $this->subscriberProjectManager->find($id);
        return $this->render('home/subscriptionSummary.html.twig', [
            'subscription' => $subscription
        ]);
    }

    /**
     * @Route("/subscription/checkout/{id}", name="checkoutProject")
     */
    public function checkout(Request $request, $id){

        $eumform = $this->formFactory->create(EumPaymentFormType::class);
        $eumform->handleRequest($request);

        $omform = $this->formFactory->create(OmPaymentFormType::class);
        $omform->handleRequest($request);

        $mtnform = $this->formFactory->create(MtnPaymentFormType::class);
        $mtnform->handleRequest($request);

        $afrikpayform = $this->formFactory->create(AfrikpayPaymentFormType::class);
        $afrikpayform->handleRequest($request);

        $bankReceiptForm = $this->formFactory->create(BankReceiptFormType::class);
        $bankReceiptForm ->handleRequest($request);

        $package = new Package(new EmptyVersionStrategy());

        $subscription = $this->subscriberProjectManager->find($id);

        if ($request->isMethod('POST')) {

            $afrikpayform_phone = $afrikpayform->get('phone_number')->getData();
            $afrikpayform_amount = $afrikpayform->get('amount')->getData();

            $eumform_phone = $eumform->get('phone_number')->getData();
            $eumform_amount = $eumform->get('amount')->getData();

            $omform_phone = $omform->get('phone_number')->getData();
            $omform_amount = $omform->get('amount')->getData();

            $mtnform_phone = $mtnform->get('phone_number')->getData();
            $mtnform_amount = $mtnform->get('amount')->getData();

            if ($afrikpayform->isSubmitted() && $afrikpayform->isValid()) {
                //dump($request);die;
                $response = $this->runPayment("afrikpay", "237".$afrikpayform_phone, $afrikpayform_amount, "purchaseref");

                $bodyResponse = $response->getBody()->getContents();
                $decodedBody = json_decode($bodyResponse);

                if($decodedBody->{'message'} == "success"){

                    //save payment
                    return $this->redirectToRoute('paymentStatus', [
                        "status" => "success"
                    ]);
                }else{
                    return $this->redirectToRoute('paymentStatus', [
                        "status" => "failed"
                    ]);
                }
            }

            if ($mtnform->isSubmitted() && $mtnform->isValid()) {
                //dump($request);die;
                $response = $this->runPayment("mtn_mobilemoney_cm", $mtnform_phone, $mtnform_amount, "purchaseref");

                $bodyResponse = $response->getBody()->getContents();
                $decodedBody = json_decode($bodyResponse);

                if($decodedBody->{'message'} == "success"){

                    //save payment
                    return $this->redirectToRoute('paymentStatus', [
                        "status" => "success"
                    ]);
                }else{
                    return $this->redirectToRoute('paymentStatus', [
                        "status" => "failed"
                    ]);
                }
            }

            if ($omform->isSubmitted() && $omform->isValid()) {
                //dump($request);die;
                $response = $this->runPayment("orange_money_cm", $omform_phone, $omform_amount, "purchaseref");

                $bodyResponse = $response->getBody()->getContents();
                $decodedBody = json_decode($bodyResponse);

                if($decodedBody->{'message'} == "success"){

                    //save payment
                    return $this->redirectToRoute('paymentStatus', [
                        "status" => "success"
                    ]);
                }else{
                    return $this->redirectToRoute('paymentStatus', [
                        "status" => "failed"
                    ]);
                }
            }

            if ($eumform->isSubmitted() && $eumform->isValid()) {
                //dump($request);die;
                $response = $this->runPayment("express_union_mobilemoney", $eumform_phone, $eumform_amount, "purchaseref");

                $bodyResponse = $response->getBody()->getContents();
                $decodedBody = json_decode($bodyResponse);

                if($decodedBody->{'message'} == "success"){

                    //save payment
                    return $this->redirectToRoute('paymentStatus', [
                        "status" => "success"
                    ]);
                }else{
                    return $this->redirectToRoute('paymentStatus', [
                        "status" => "failed"
                    ]);
                }
            }
        }

        return $this->render('home/checkout.html.twig', [
            "subscription" => $subscription,
            "package" => $package,
            'eumform' => $eumform->createView(),
            'omform' => $omform->createView(),
            'mtnform' => $mtnform->createView(),
            'afrikpayform' => $afrikpayform->createView(),
            'bankReceiptForm'  => $bankReceiptForm->createView()
        ]);
    }

    /**
     * @Route("payment/payment/succeed", name="paymentSucceed")
     */
    public function paymentSucceed(){

        return $this->render('home/subscriptionPaymentSucceed.html.twig');
    }

    /**
     * @Rest\Post(
     *    path = "/identification/phone/otp",
     *     options={"expose"=true},
     *    name = "phoneOtpSend"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function phoneOtpSend(Request $request, OtpService $otpService)
    {
        $content = $request->getContent();
        $decodedContent = json_decode($content);

        $subscriberIdentity = $decodedContent->subscriberIdentity;
        $subscriberPhone = $decodedContent->subscriberPhone;

        $otpLine = $otpService->generateOtpLine("create_subscription", $subscriberIdentity, $subscriberPhone, null);

        return new JsonResponse([
            'Otp' => $otpLine,
            'status' => "Success"
        ]);
    }

    /**
     * @Rest\Post(
     *    path = "/identification/email/otp/send/",
     *     options={"expose"=true},
     *    name = "identificationOtpSend"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function identificationOtpSend(Request $request, OtpService $otpService)
    {
        $content = $request->getContent();
        $decodedContent = json_decode($content);

        $subscriberIdentity = $decodedContent->subscriberIdentity;
        $subscriberEmail = $decodedContent->subscriberEmail;

        $otpLine = $otpService->generateOtpLine("create_account", $subscriberIdentity, null, $subscriberEmail);

        return new JsonResponse([
            'Otp' => $otpLine,
            'status' => "Success"
        ]);
    }


    /**
     * @Rest\Post(
     *    path = "/identification/otp/validate",
     *     options={"expose"=true},
     *    name = "identificationOtpValidate"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function identificationOtpValidate(Request $request, OtpService $otpService)
    {
        $content = $request->getContent();
        $decodedContent = json_decode($content);

        $subscriberOtp = $decodedContent->subscriberOtp;
        $subscriberPhone = $decodedContent->subscriberPhone;

        try {
            $otpLineConfirm = $otpService->confirmOtpLine("create_account", $subscriberPhone, $subscriberOtp);
            return new JsonResponse([
                'Otp' => $otpLineConfirm,
                'status' => "Success"
            ]);
        } catch(OtpException $e) {
            return new JsonResponse([
                'Otp' => "",
                'status' => "Failed"
            ]);
        }
    }

    /**
     * @Rest\Get(
     *    path = "/get/subscriber",
     *     options={"expose"=true},
     *    name = "getSubscriber"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function getSubscriber(Request $request)
    {
        $userId = $request->get('userId');

        $subscriber = $this->userService->getSubscriber($userId);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $result = $serializer->serialize($subscriber, 'json');

        if(count((array)$subscriber)){
            return new JsonResponse([
                'subscriber' => json_decode($result)
            ]);
        }

        return new JsonResponse([
            'Result' => False
        ]);
    }

    /**
     * @Rest\Post(
     *    path = "/subscription/save",
     *     options={"expose"=true},
     *    name = "saveSubscription"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function saveSubscription(Request $request)
    {
        $content = $request->getContent();
        $decodedContent = json_decode($content);

        $subscriberPartnerFirstName = $decodedContent->subscriberPartnerFirstName;
        $subscriberPartnerLastName = $decodedContent->subscriberPartnerLastName;
        $subscriberPartnerPhone = $decodedContent->subscriberPartnerPhone;
        $subscriberPartnerEmail = $decodedContent->subscriberPartnerEmail;
        $subscriptionPartNumber = $decodedContent->subscriptionPartNumber;
        $subscriberMobileAccountOperator = $decodedContent->subscriberMobileAccountOperator;
        $subscriberMobileAccountNumber = $decodedContent->subscriberMobileAccountNumber;
        $subscriptionBankName = $decodedContent->subscriptionBankName;
        $subscriptionBankCode = $decodedContent->subscriptionBankCode;
        $subscriptionBankRib = $decodedContent->subscriptionBankRib;
        $subscriptionBankAgence = $decodedContent->subscriptionBankAgence;
        $subscriptionBankAccountNumber = $decodedContent->subscriptionBankAccountNumber;
        $subscriptionBankKey = $decodedContent->subscriptionBankKey;
        $subscriptionBankIban = $decodedContent->subscriptionBankIban;
        $subscriptionCampaignAwareness = $decodedContent->subscriptionCampaignAwareness;
        $subscriberId = $decodedContent->subscriberId;
        $projectId = $decodedContent->projectId;

        $subscriberProject = new SubscriberProject();
        $subscriberProject->setSubscriptionMobileAccount([
            "subscription_mobile_account" => $subscriberMobileAccountNumber,
            "subscription_mobile_payment" => $subscriberMobileAccountOperator
        ]);
        $subscriberProject->setSubscriptionBankAccount([
            "subscription_bank_name" => $subscriptionBankName,
            "subscription_bank_code" => $subscriptionBankCode,
            "subscription_bank_rib" => $subscriptionBankRib,
            "subscription_bank_agence" => $subscriptionBankAgence,
            "subscription_bank_number" => $subscriptionBankAccountNumber,
            "subscription_bank_key" => $subscriptionBankKey,
        ]);
        $subscriberProject->setSubscriptionPartner([
            "subscription_partner_firstname" => $subscriberPartnerFirstName,
            "subscription_partner_lastname" => $subscriberPartnerLastName,
            "subscription_partner_phone" => $subscriberPartnerPhone,
            "subscription_partner_email" => $subscriberPartnerEmail
        ]);
        $subscriberProject->setSubscriptionNumber($subscriptionPartNumber);
        $subscriberProject->setSubscriptionCampaignAwareness($subscriptionCampaignAwareness);
        $subscriberProject->setSubscriptionMobileOperator($subscriberMobileAccountOperator);

        $subscriber = $this->subscriberManager->find($subscriberId);
        $project = $this->projectService->getProject($projectId);

        $updatedSubscriberProject = $this->userService->registerEngagement($subscriber,
            $project,
            $subscriberProject
        );

        $masterAdmin = $this->userManager->findBy(["username" => "admin"]);

        //$engagementSentEvent = new EngagementSentEvent($subscriberProject);
        //$this->eventDispatcher->dispatch(EngagementSentEvent::NAME, $engagementSentEvent);

        return new JsonResponse([
            'subscriptionData' => [
                'subscriberPartnerFirstName' => $subscriberPartnerFirstName,
                'subscriberPartnerLastName' => $subscriberPartnerLastName,
                'subscriberPartnerPhone' => $subscriberPartnerPhone,
                'subscriberPartnerEmail' => $subscriberPartnerEmail,
                'subscriptionPartNumber' => $subscriptionPartNumber,
                'subscriberMobileAccountOperator' => $subscriberMobileAccountOperator,
                'subscriberMobileAccountNumber' => $subscriberMobileAccountNumber,
                'subscriptionBankName' => $subscriptionBankName,
                'subscriptionBankCode' => $subscriptionBankCode,
                'subscriptionBankRib' => $subscriptionBankRib,
                'subscriptionBankAgence' => $subscriptionBankAgence,
                'subscriptionBankAccountNumber' => $subscriptionBankAccountNumber,
                'subscriptionBankKey' => $subscriptionBankKey,
                'subscriptionBankIban' => $subscriptionBankIban,
                'subscriptionCampaignAwareness' => $subscriptionCampaignAwareness,
                'subscriberId' => $subscriberId,
                'projectId' => $projectId
            ],'subscriptionId' => $updatedSubscriberProject->getId()
        ]);
    }


    /**
     * @Rest\Get(
     *    path = "/get/subscription",
     *     options={"expose"=true},
     *    name = "getSubscription"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function getSubscription(Request $request)
    {
        $userId = $request->get('userId');

        $subscriber = $this->userService->getSubscriber($userId);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $result = $serializer->serialize($subscriber, 'json');

        if(count((array)$subscriber)){
            return new JsonResponse([
                'subscriber' => json_decode($result)
            ]);
        }

        return new JsonResponse([
            'Result' => False
        ]);
    }

    /**
     * @Route("/user/payment/confirm/{id}/{payment_method}/{amount}/{phone}/{upId}", options={"expose"=true}, name="paymentConfirm")
     */
    public function paymentConfirm(Request $request, $id, $upId, $payment_method, $amount, $phone){

        $package = new Package(new EmptyVersionStrategy());

        $project = $this->projectService->getProject($id);

        $user = $this->security->getUser();

        $form = $this->formFactory->create(PaymentConfirmFormType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            if ($form->isSubmitted() && $form->isValid()) {

                if($payment_method == "Afrikpay"){

                    $response = $this->runPayment("afrikpay", "237".$phone, $amount, "purchaseref");

                    $bodyResponse = $response->getBody()->getContents();
                    $decodedBody = json_decode($bodyResponse);

                    if($decodedBody->{'message'} == "success"){

                        $this->contributorService->saveContribution($user, $project, $upId, $phone, $amount);
                        return $this->redirectToRoute('paymentStatus', [
                            "status" => "success"
                        ]);
                    }else{
                        return $this->redirectToRoute('paymentStatus', [
                            "status" => "failed"
                        ]);
                    }

                }else if($payment_method == "Orange Money"){

                    $response = $this->runPayment("orange_money_cm", $phone, $amount, "purchaseref");

                    $bodyResponse = $response->getBody()->getContents();
                    $decodedBody = json_decode($bodyResponse);

                    if($decodedBody->{'message'} == "success"){

                        $this->contributorService->saveContribution($user, $project, $upId, $phone, $amount);
                        //$this->addFlash('success', 'Votre paiement a réussi');
                        return $this->redirectToRoute('paymentStatus', [
                            "status" => "success"
                        ]);
                    }else{
                        return $this->redirectToRoute('paymentStatus', [
                            "status" => "failed"
                        ]);
                    }


                }else if($payment_method == "Mtn Mobile Money"){

                    $response = $this->runPayment("mtn_mobilemoney_cm", $phone, $amount, "purchaseref");

                    $bodyResponse = $response->getBody()->getContents();
                    $decodedBody = json_decode($bodyResponse);

                    //dump($decodedBody); die;

                    if($decodedBody->{'message'} == "success"){

                        $this->contributorService->saveContribution($user, $project, $upId, $phone, $amount);
                        //$this->addFlash('success', 'Votre paiement a réussi');
                        return $this->redirectToRoute('paymentStatus', [
                            "status" => "success"
                        ]);
                    }else{
                        return $this->redirectToRoute('paymentStatus', [
                            "status" => "failed"
                        ]);
                    }

                }else if($payment_method == "Express Union Mobile Money"){

                    $response = $this->runPayment("express_union_mobilemoney", $phone, $amount, "purcharef");

                    $bodyResponse = $response->getBody()->getContents();
                    $decodedBody = json_decode($bodyResponse);

                    //dump($decodedBody); die;

                    if($decodedBody->{'message'} == "success"){

                        $this->contributorService->saveContribution($user, $project, $upId, $phone, $amount);
                        //$this->addFlash('success', 'Votre paiement a réussi');
                        return $this->redirectToRoute('paymentStatus', [
                            "status" => "success"
                        ]);
                    }else{
                        return $this->redirectToRoute('paymentStatus', [
                            "status" => "failed"
                        ]);
                    }

                }else{
                    return $this->redirectToRoute('home');
                }
            }
        }

        return $this->render('home/paymentConfirm.html.twig', [
            "project" => $project,
            "package" => $package,
            "payment_method" =>  $payment_method ,
            "amount" =>  $amount,
            "phone" =>  $phone,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/payment/status/{status}", name="paymentStatus")
     */
    public function paymentStatus($status){

        if($status == "success"){
            return $this->render('home/paymentSucceed.html.twig');
        }else if($status == "failed"){
            return $this->render('home/paymentFailed.html.twig');
        }else{
            return $this->render('home/paymentFailed.html.twig');
        }
    }

    public function runPayment($provider, $phone, $amount, $purchaseref){

        $client = new \GuzzleHttp\Client();
        $hash    = md5($provider.$phone.$amount."8170b020b97d298dde3096d9a6c5cb9a");
        $response = $client->request('POST', 'http://92.222.74.105:8086/api/ecommerce/collect/', [
            'json' => [
                'provider' => $provider,
                'reference' => $phone,
                'amount' => $amount,
                'purchaseref' => $purchaseref,
                'apiKey' => '8170b020b97d298dde3096d9a6c5cb9a',
                'store'=> 'AFC9980',
                'hash' => $hash,
                'notifurl' => 'http://crowdfunding.test/user/payment/notif/',
            ]
        ]);

        return $response;
    }

}