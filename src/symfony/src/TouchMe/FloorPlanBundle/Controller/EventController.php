<?php
namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TouchMe\FloorPlanBundle\Form\EventType;
use TouchMe\FloorPlanBundle\Entity\Event;

class EventController extends Controller {
    public function indexAction() {
        $events = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Event')->findAllOrderedByStarttime();
        return $this->render('TouchMeFloorPlanBundle:Event:index.html.twig', array('events' => $events));
    }
    
    public function newAction() {
        $form = $this->createForm(new EventType(), new Event(), array('action' => $this->generateUrl('event_create')));
        return $this->render('TouchMeFloorPlanBundle:Event:new.html.twig', array('form' => $form->createView()));
    }
    
    public function createAction() {
        $form = $this->createForm(new EventType(), new Event());
        $form->bind($this->getRequest());
        
        $event = $form->getData();
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            
            return $this->redirect($this->generateUrl('event'));
        }
        return $this->render('TouchMeFloorPlanBundle:Event:new.html.twig', array('form' => $form->createView()));
    }
    
    public function removeAction($id) {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('TouchMeFloorPlanBundle:Event')->findOneById($id);
        if ($event) {
            $em->remove($event);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('event'));
    }

    public function removeallAction() {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('TouchMeFloorPlanBundle:Event')->findAll();
        if ($events) {
            foreach ($events as $event){
                $em->remove($event);
                $em->flush();
            }
        }
        
        return $this->redirect($this->generateUrl('event'));
    }
    
    public function editAction($id) {
        $event = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Event')->findOneById($id);
        if ($event) {
            $form = $this->createForm(new EventType(), $event, array('action' => $this->generateUrl('event_save', array('id' => $event->getId()))));
        }
        
        return $this->render('TouchMeFloorPlanBundle:Event:edit.html.twig', array('form' => $form->createView()));
    }
    
    public function saveAction($id) {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('TouchMeFloorPlanBundle:Event')->findOneById($id);
        
        if ($event) {
            $form = $this->createForm(new EventType(), $event);
            $form->bind($this->getRequest());
            
            $event = $form->getData();
            
            if ($form->isValid()) {
                
                $em->persist($event);
                $em->flush();
                
                return $this->redirect($this->generateUrl('event'));
            }
            return $this->render('TouchMeFloorPlanBundle:Event:edit.html.twig', array('form' => $form->createView()));
        }
        return $this->redirect($this->generateUrl('event'));
    }
}
