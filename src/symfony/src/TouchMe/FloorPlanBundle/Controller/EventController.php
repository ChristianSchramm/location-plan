<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
  public function indexAction($name)
  {
    return $this->render('TouchMeFloorPlanBundle:Default:index.html.twig', array('name' => $name));
  }

  public function getAllAction()
  {
    $events = $this->getDoctrine()->getRepository('LocationPlanBundle:Event')->findAll();

    return array('events' => $events);
  }
}
