<?php
namespace Location\PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EventController extends Controller {
    /**
     * @Route("/admin/events", name="admin_event")
     * @Template()
     */
    public function indexAction() {
        return array();
    }
}
