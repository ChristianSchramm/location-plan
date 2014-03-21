<?php
namespace Location\PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {
    /**
     * @Route("/", name="home")
     * @Route("")
     * @Template()
     */
    public function indexAction() {
        return array();
    }
    /**
     * @Route("/events", name="event")
     * @Template()
     */
    public function eventAction() {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('LocationPlanBundle:Event')->findAll();
        return array('events' => $events);
    }
    /**
     * @Route("/rooms", name="room")
     * @Template()
     */
    public function roomAction() {
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository('LocationPlanBundle:Room')->findAll();
        return array('rooms' => $rooms);
    }
}
