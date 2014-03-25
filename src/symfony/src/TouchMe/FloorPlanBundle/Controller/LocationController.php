<?php
namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TouchMe\FloorPlanBundle\Form\LocationType;
use TouchMe\FloorPlanBundle\Entity\Location;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LocationController extends Controller 
{
    public function indexAction() {
        $locations = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Location')->findAllOrderedByNumber();
        return $this->render('TouchMeFloorPlanBundle:Location:index.html.twig', array('locations' => $locations));
    }
    
    public function newAction() 
    {
        $form = $this->createForm(new LocationType(), new Location(), array(
    'action' => $this->generateUrl('location_create')));
        return $this->render('TouchMeFloorPlanBundle:Location:new.html.twig', array('form' => $form->createView()));
    }

    public function createAction() 
    {
      $form = $this->createForm(new LocationType(), new Location());
      $form->bind($this->getRequest());

      $location = $form->getData();

      if ($form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($location);
        $em->flush();
        
        return $this->redirect($this->generateUrl('location'));
      }
      return $this->render('TouchMeFloorPlanBundle:Location:new.html.twig', array('form' => $form->createView()));

    }
}
