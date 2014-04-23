<?php
namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TouchMe\FloorPlanBundle\Form\LocationType;
use TouchMe\FloorPlanBundle\Entity\Location;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LocationController extends Controller {
    public function indexAction() {
        $locations = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Location')->findAllOrderedByNumber();
        return $this->render('TouchMeFloorPlanBundle:Location:index.html.twig', array('locations' => $locations));
    }
    
    public function newAction() {
        $form = $this->createForm(new LocationType(), new Location(), array('action' => $this->generateUrl('location_create')));
        return $this->render('TouchMeFloorPlanBundle:Location:new.html.twig', array('form' => $form->createView()));
    }
    
    public function createAction() {
        $form = $this->createForm(new LocationType(), new Location());
        $form->bind($this->getRequest());
        
        $location = $form->getData();
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();
            
            return $this->redirect($this->generateUrl('location'));
        }
        return $this->render('TouchMeFloorPlanBundle:Location:new.html.twig', array('form' => $form->createView()));
    }
    
    public function removeAction($id) {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository('TouchMeFloorPlanBundle:Location')->findOneById($id);


        if ($location) {

            $room = $em->getRepository('TouchMeFloorPlanBundle:Event')->findOneByLocation($location);
            if (!$room){

                $em->remove($location);
                $em->flush();
            }else {
                $this->get('session')->getFlashBag()->add(
                'notice',
                'Raum konnte nicht gelöscht werden, da in ihm Veranstaltungen stattfinden.'
                );
            }
        }
        
        return $this->redirect($this->generateUrl('location'));
    }
    
    public function editAction($id) {
        $location = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Location')->findOneById($id);
        if ($location) {
            $form = $this->createForm(new LocationType(), $location, array('action' => $this->generateUrl('location_save', array('id' => $location->getId()))));
        }
        
        return $this->render('TouchMeFloorPlanBundle:Location:edit.html.twig', array('form' => $form->createView()));
    }
    
    public function saveAction($id) {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository('TouchMeFloorPlanBundle:Location')->findOneById($id);
        
        if ($location) {
            $form = $this->createForm(new LocationType(), $location);
            $form->bind($this->getRequest());
            
            $location = $form->getData();
            
            if ($form->isValid()) {
                
                $em->persist($location);
                $em->flush();
                
                return $this->redirect($this->generateUrl('location'));
            }
            return $this->render('TouchMeFloorPlanBundle:Location:edit.html.twig', array('form' => $form->createView()));
        }
        return $this->redirect($this->generateUrl('location'));
    }
}
