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
        return array();
    }
    /**
     * @Route("/rooms", name="room")
     * @Template()
     */
    public function roomAction() {
        return array();
    }
}
