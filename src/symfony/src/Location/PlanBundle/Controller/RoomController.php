<?php
namespace Location\PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RoomController extends Controller {
      /**
     * @Route("/admin/rooms", name="admin_room")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository('LocationPlanBundle:Room')->findAllOrderedByNumber();
        return array('rooms' => $rooms);
    }
}
