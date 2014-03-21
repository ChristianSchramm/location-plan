<?php
namespace Location\PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ExportController extends Controller {
    /**
     * @Route("/export/json")
     */
    public function jsonAction() {
        
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('LocationPlanBundle:Event')->findAll();
        
        $response = null;
        foreach ($events as $key => $value) {
            $response[] = $value->jsonSerialize();
        }
        
        return new JsonResponse($response);
    }
    /**
     * @Route("/export/download")
     * @Template()
     */
    public function downloadAction() {
    }
}
