<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
  public function indexAction()
  {
    $events = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Event')->findAllOrderedByStarttime();
    return $this->render('TouchMeFloorPlanBundle:Event:index.html.twig', array('events' => $events));
  }
}
