<?php
namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TouchMe\FloorPlanBundle\Form\LocationType;
use TouchMe\FloorPlanBundle\Entity\Location;

class LocationController extends Controller {
    public function indexAction() {
        $locations = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Location')->findAllOrderedByNumber();
        return $this->render('TouchMeFloorPlanBundle:Location:index.html.twig', array('locations' => $locations));
    }
    
    public function newAction() {
        $form = $this->createForm(new LocationType(), new Location());
        return $this->render('TouchMeFloorPlanBundle:Location:new.html.twig', array('form' => $form->createView()));
    }
}
