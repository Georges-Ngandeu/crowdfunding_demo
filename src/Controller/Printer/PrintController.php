<?php

namespace App\Controller\Printer;

use App\Manager\SubscriberProjectManager;
use App\Services\PdfService;
use App\Services\SubscriptionService;
use App\Services\Tools\FileService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrintController extends AbstractController
{
    /**
     * @Route("/print/subscription/{id}", name="subscription")
     */
    public function subscription(Request $request, $id, PdfService $pdf, SubscriberProjectManager $subscriberProjectManager, FileService $fileService)
    {
        //$id = $request->get("subscription_id");
        $subscription = $subscriberProjectManager->find($id);
        $template = "bill/subscribe.html.twig";
        $html = $this->renderView(
            $template,
            array(
                'subscription'  => $subscription,
            )
        );
        $directory =  $this->getParameter("kernel.project_dir"). "/public/subscription/subscription". $id .".pdf";
        $pdf->print($html, "P", "A4", $directory);
    }

     /**
     * @Route("/print/contract/{id}", name="contract")
     */
    public function contract(Request $request, $id, PdfService $pdf, SubscriberProjectManager $subscriberProjectManager, SubscriptionService $subscriptionService)
    {
        //$id = $request->get("subscription_id");
        $subscription = $subscriberProjectManager->find($id);
        $subscriptionService->allowToManager($subscription);
        $template = "bill/contract.html.twig";
        $html = $this->renderView(
            $template,
            array(
                'subscription'  => $subscription,
            )
        );
        
        $directory =  $this->getParameter("kernel.project_dir"). "/public/contract/contract". $id .".pdf";
        $pdf->print($html, "L", "A4", $directory);

    }



     /**
     * @Route("/print/reconduction", name="printReconduction")
     */
    public function reconduction(Request $request, PdfService $pdf)
    {
        
        $template = "bill/reconduction.html.twig";
        $html = $this->renderView(
            $template,
            array(
            'data'  => $data,
            )
        );

        return $pdf->print($html, "P", "A4");
    }
}