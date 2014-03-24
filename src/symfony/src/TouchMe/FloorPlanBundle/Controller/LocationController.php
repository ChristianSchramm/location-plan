<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocationController extends Controller
{
    public function indexAction()
    {
        $locations = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Location')->findAllOrderedByNumber();
        return $this->render('TouchMeFloorPlanBundle:Location:index.html.twig', array('locations' => $locations));
    }
}
