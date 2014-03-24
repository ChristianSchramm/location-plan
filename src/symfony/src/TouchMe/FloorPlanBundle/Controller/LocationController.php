<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TouchMeFloorPlanBundle:Default:index.html.twig', array('name' => $name));
    }
}
