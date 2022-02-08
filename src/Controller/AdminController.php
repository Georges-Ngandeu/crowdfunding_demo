<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 19/08/2020
 * Time: 18:13
 */

namespace App\Controller;
use App\Events\RejectValidationEvent;
use App\Events\RequestValidationEvent;
use App\Form\AdminFormType;
use App\Form\EditProjectFormType;
use App\Form\ManagerFormType;
use App\Form\EditProjectFormFilesType;
use App\Form\OtpSegmentFormType;
use App\Form\ProjectFormType;
use App\Form\ResetPasswordFormType;
use App\Manager\SubscriberManager;
use App\Services\AdminService;
use App\Services\ManagerService;
use App\Services\OtpService;
use App\Services\ProjectService;
use App\Services\SubscriptionService;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class AdminController extends AbstractController
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var ManagerService
     */
    private $managerService;
    /**
     * @var AdminService
     */
    private $adminService;
    /**
     * @var ProjectService
     */
    private $projectService;
    /**
     * @var SubscriptionService
     */
    private $subscriptionService;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var SubscriberManager
     */
    private $subscriberManager;
    /**
     * @var OtpService
     */
    private $otpService;

    /**
     * AdminController constructor.
     */
    public function __construct(FormFactoryInterface $formFactory,
                                ManagerService $managerService,
                                AdminService $adminService,
                                ProjectService $projectService,
                                SubscriptionService $subscriptionService,
                                EventDispatcherInterface $eventDispatcher,
                                SubscriberManager $subscriberManager,
                                OtpService $otpService)
    {
        $this->formFactory = $formFactory;
        $this->managerService = $managerService;
        $this->adminService = $adminService;
        $this->projectService = $projectService;
        $this->subscriptionService = $subscriptionService;
        $this->eventDispatcher = $eventDispatcher;
        $this->subscriberManager = $subscriberManager;
        $this->otpService = $otpService;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        //$projectStats= $this->projectService->getAllPublishProjectStats();
        $projectStats = [];
        return $this->render('admin/index.html.twig', [
            'projectStats'=> $projectStats
        ]);
    }

    /**
     * @Route("/admin/password/reset", name="adminResetPassword")
     */
    public function resetPassword(Request $request)
    {
        $form = $this->formFactory->create(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $admin_password = $form->get('password')->getData();

            if ($form->isSubmitted() && $form->isValid()) {

                //dump($project_mainImage); die;
                $user = $this->security->getUser();
                $user->setPassword( $this->userPasswordEncoder->encodePassword($user, $admin_password));
                $this->userManager->updateUser($user);

                $this->addFlash('success', 'Votre mot de passe été modifié avec succès');
                return $this->redirectToRoute('admin');
            }
        }

        return $this->render('admin/resetPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/project/list", name="listProject")
     */
    public function listProject()
    {
        $projects= $this->projectService->getAllProjects();
        return $this->render('admin/listProject.html.twig', [
            'controller_name' => 'AdminController',
            'projects' => $projects
        ]);
    }

    /**
     * @Route("/admin/project/create", name="createProject")
     */
    public function createProject(Request $request)
    {
        $form = $this->formFactory->create(ProjectFormType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $project_name = $form->get('project_name')->getData();
            $project_short_description = $form->get('project_shortdescription')->getData();
            $project_cost = $form->get('project_cost')->getData();
            $project_startdate = $form->get('project_startdate')->getData();
            $project_enddate = $form->get('project_enddate')->getData();
            $project_mainImage = $form->get('project_mainimage')->getData();
            $project_images = $form->get('project_images')->getData();
            $project_long_description = $form->get('project_longdescription')->getData();
            $project_documents = $form->get('project_documents')->getData();
            $project_videoUrl = $form->get('project_videourl')->getData();
            $number_part = $form->get('project_numberaction')->getData();
            $min_number_part = $form->get('project_minnumberaction')->getData();

            $userId = $this->getUser()->getId();

            if ($form->isSubmitted()) {

                //dump($project_author); die;

                $this->projectService->createProject(
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
                );

                return $this->redirectToRoute('listProject');
            }
        }

        return $this->render('admin/createProject.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/project/edit/{id}", name="projectEdit")
     */
    public function editProject(Request $request, $id)
    {
        $project = $this->projectService->getProject($id);

        $form = $this->formFactory->create(EditProjectFormType::class, $project);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $project_short_description = $form->get('project_shortdescription')->getData();
            $project_cost = $form->get('project_cost')->getData();
            $project_startdate = $form->get('project_startdate')->getData();
            $project_enddate = $form->get('project_enddate')->getData();
            $project_long_description = $form->get('project_longdescription')->getData();
            $project_videoUrl = $form->get('project_videourl')->getData();
            $number_part = $form->get('project_numberaction')->getData();
            $min_number_part = $form->get('project_minnumberaction')->getData();

            if ($form->isSubmitted()) {

                //dump($project_author); die;

                $this->projectService->editProject(
                    $project_short_description,
                    $project_cost,
                    $project_startdate,
                    $project_enddate,
                    $project_long_description,
                    $project_videoUrl,
                    $number_part,
                    $min_number_part,
                    $project
                );

                return $this->redirectToRoute('listProject');
            }
        }

        return $this->render('admin/editProject.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/project/list/files", name="listProjectFiles")
     */
    public function listProjectFiles()
    {
        //$projects= $this->projectService->getAllProjects();
        $projects = [];
        return $this->render('admin/listProjectFiles.html.twig', [
            'controller_name' => 'AdminController',
            'projects' => $projects
        ]);
    }


    /**
     * @Route("/admin/projectfiles/edit/{id}", name="projectFilesEdit")
     */
    public function editProjectFiles(Request $request, $id)
    {
        $project = $this->projectService->getProject($id);

        $form = $this->formFactory->create(EditProjectFormFilesType::class, $project);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $project_mainImage = $form->get('mainImage')->getData();
            $project_images = $form->get('images')->getData();
            $project_documents = $form->get('documents')->getData();

            if ($form->isSubmitted()) {

                //dump($project_author); die;

                $this->projectService->editProjectFiles(
                    $project_mainImage,
                    $project_images,
                    $project_documents,
                    $project
                );

                return $this->redirectToRoute('listProjectFiles');
            }
        }

        return $this->render('admin/editProjectFiles.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/manager/list", name="listManager")
     */
    public function listManager()
    {
        $managers= $this->managerService->getAllManagers();
        //$managers = [];

        return $this->render('admin/listManager.html.twig', [
            'controller_name' => 'AdminController',
            'managers' => $managers
        ]);
    }


    /**
     * @Route("/admin/admin/list", name="listAdmin")
     */
    public function listAdmin()
    {
        $admins = $this->adminService->getAllAdmins();
        //$managers = [];

        return $this->render('admin/listAdmin.html.twig', [
            'controller_name' => 'AdminController',
            'admins' => $admins
        ]);
    }

    /**
     * @Route("/admin/manager/create", name="createManager")
     */
    public function createManager(Request $request)
    {
        $form = $this->formFactory->create(ManagerFormType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $manager_firstname = $form->get('first_name')->getData();
            $manager_lastname = $form->get('last_name')->getData();
            $manager_phone = $form->get('phone')->getData();
            $manager_region = $form->get('region')->getData();

            $manager_username = $form->get('user_name')->getData();
            $manager_email = $form->get('email')->getData();
            $manager_password = $form->get('password')->getData();

            if ($form->isSubmitted() && $form->isValid()) {

                //dump($project_mainImage); die;

                $this->managerService->createManager(
                    $manager_firstname,
                    $manager_lastname,
                    $manager_phone,
                    $manager_region,

                    $manager_username,
                    $manager_email,
                    $manager_password
                );

                return $this->redirectToRoute('listManager');
            }
        }

        return $this->render('admin/createManager.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/admin/create", name="createAdmin")
     */
    public function createAdmin(Request $request)
    {
        $form = $this->formFactory->create(AdminFormType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $admin_firstname = $form->get('first_name')->getData();
            $admin_lastname = $form->get('last_name')->getData();
            $admin_phone = $form->get('phone')->getData();
            $admin_region = $form->get('region')->getData();

            $admin_username = $form->get('user_name')->getData();
            $admin_email = $form->get('email')->getData();
            $admin_password = $form->get('password')->getData();

            if ($form->isSubmitted() && $form->isValid()) {

                //dump($project_mainImage); die;

                $this->adminService->createAdmin(
                    $admin_firstname,
                    $admin_lastname,
                    $admin_phone,
                    $admin_region,

                    $admin_username,
                    $admin_email,
                    $admin_password
                );

                return $this->redirectToRoute('listAdmin');
            }
        }

        return $this->render('admin/createAdmin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit/otp/segment/{id}", name="editOtpSegment")
     */
    public function editOtpSegment(Request $request, $id)
    {
        $otpSegment = $this->otpService->getOtpSegment($id);

        $form = $this->formFactory->create(OtpSegmentFormType::class, $otpSegment);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $slug = $form->get('slug')->getData();
            $name = $form->get('name')->getData();
            $sms = $form->get('sms')->getData();
            $email = $form->get('email')->getData();
            $size = $form->get('size')->getData();

            if ($form->isSubmitted() && $form->isValid()) {

                $this->adminService->editOtpSegment(
                    $slug,
                    $name,
                    $sms,
                    $email,
                    $size,
                    $otpSegment
                );

                return $this->redirectToRoute('listOtpConfig');
            }
        }

        return $this->render('admin/editOtpSegment.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/request/list", name="listSubscription")
     */
    public function listSubscription()
    {
        $subscriptions = $this->subscriptionService->getAllRequest();
        return $this->render('admin/listSubscriptions.html.twig', [
            'controller_name' => 'AdminController',
            'subscriptions' => $subscriptions
        ]);
    }

    /**
     * @Route("/admin/otp/config/list", name="listOtpConfig")
     */
    public function listOtpConfig()
    {
        $otpSegments = $this->otpService->getAllOtpSegment();
        return $this->render('admin/listOtpSegments.html.twig', [
            'controller_name' => 'AdminController',
            'otpSegments' => $otpSegments
        ]);
    }

    /**
     * @Route("/admin/bank_orders/list", name="listBankOrder")
     */
    public function bankOrdersList()
    {
        $orders = $this->projectService->getAllBankOrders();
        return $this->render('admin/bankOrderList.html.twig', [
            'controller_name' => 'AdminController',
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/admin/project/status/{id}", name="projectStatus")
     */
    public function setProjectStatus($id){
        $project = $this->projectService->getProject($id);

        $theProject = $this->projectService->setProjectStatus($project);

        return $this->redirectToRoute('listProject');
    }

    /**
     * @Route("/admin/investor/{username}", name="investorDetail")
     */
    public function investorDetail($username)
    {
        $user =  $this->subscriberManager->findBy(["subscriber_username" => $username]);
        $package = new Package(new EmptyVersionStrategy());
        return $this->render('admin/investorDetail.html.twig', [
            'user'=> $user,
            'package' => $package
        ]);
    }

    /**
     * @Route("/admin/request/validate/{id}", name="contributionValidate")
     */
    public function validateRequest($id)
    {
        $subscription = $this->subscriptionService->validateRequest($id);

        $requestValidationEvent = new RequestValidationEvent($subscription);

        $this->eventDispatcher->dispatch(RequestValidationEvent::NAME, $requestValidationEvent);

        return $this->redirectToRoute('listSubscription');
    }

    /**
     * @Route("/admin/request/reject/{id}", name="contributionReject")
     */
    public function rejectRequest($id)
    {
        $subscription = $this->subscriptionService->rejectRequest($id);

        $rejectValidationEvent = new RejectValidationEvent($subscription);

        $this->eventDispatcher->dispatch(RejectValidationEvent::NAME, $rejectValidationEvent);

        return $this->redirectToRoute('listSubscription');
    }

}