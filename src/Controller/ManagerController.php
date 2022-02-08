<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 20/08/2020
 * Time: 10:34
 */

namespace App\Controller;


use App\Form\ProjectFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ManagerController  extends AbstractController
{
//    /**
//     * @Route("/manager/project/create", name="createProject")
//     */
//    public function createProject(Request $request)
//    {
//        $form = $this->formFactory->create(ProjectFormType::class);
//        $form->handleRequest($request);
//
//        if ($request->isMethod('POST')) {
//
//            $project_author = $form->get('author')->getData();
//            $project_group = $form->get('group')->getData();
//            $project_name = $form->get('name')->getData();
//            $project_short_description = $form->get('short_description')->getData();
//            $project_cost = $form->get('cost')->getData();
//            $project_startdate = $form->get('startDate')->getData();
//            $project_enddate = $form->get('endDate')->getData();
//            $project_mainImage = $form->get('mainImage')->getData();
//            $project_images = $form->get('images')->getData();
//            $project_long_description = $form->get('long_description')->getData();
//            $project_documents = $form->get('documents')->getData();
//            $project_videoUrl = $form->get('videoUrl')->getData();
//            $number_part = $form->get('number_part')->getData();
//            $min_number_part = $form->get('min_number_part')->getData();
//
//            if ($form->isSubmitted()) {
//
//                //dump($project_author); die;
//
//                $this->projectService->createProject(
//                    $project_author,
//                    $project_group,
//                    $project_name,
//                    $project_short_description,
//                    $project_cost,
//                    $project_startdate,
//                    $project_enddate,
//                    $project_mainImage,
//                    $project_images,
//                    $project_long_description,
//                    $project_documents,
//                    $project_videoUrl,
//                    $number_part,
//                    $min_number_part
//                );
//
//                return $this->redirectToRoute('listProject');
//            }
//        }
//
//        return $this->render('admin/createProject.html.twig', [
//            'form' => $form->createView()
//        ]);
//    }
}