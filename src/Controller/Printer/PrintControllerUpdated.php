<?php

namespace App\Controller\Printer;

use App\Manager\SubscriberProjectManager;
use App\Services\PdfService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrintControllerUpdated extends AbstractController
{
//    /**
//     * @Rest\Get("/print/subscribe")
//     * @Rest\View
//     */
//    public function caisse(Request $request, PdfService $pdf, SubscriberProjectManager $subscriberProjectManager)
//    {
//        $id = $request->get("subscriber_id");
//        $subs = $subscriberProjectManager->find($id);
//        $template = "bill/subscribe.html.twig";
//        $html = $this->renderView(
//            $template,
//            array(
//                'data'  => $subs,
//            )
//        );
//
//        return $this->render($template, [
//            "data" => $subs
//        ]);
//
//        //return $pdf->print($html, "P", "A4");
//
//        // return $html;
//    }
//
//    /**
//     * @Route("/print/reconduction", name="reconduction")
//     */
//    public function reconduction(Request $request, PdfService $pdf)
//    {
//
//        $template = "bill/reconduction.html.twig";
//        $html = $this->renderView(
//            $template,
//            array(
//                'data'  => $data,
//            )
//        );
//
//        return $pdf->print($html, "P", "A4");
//    }
}