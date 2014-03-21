<?php
namespace Location\PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AssetController extends Controller {
    /**
     * @Route("/admin/assets", name="admin_asset")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $assets = $em->getRepository('LocationPlanBundle:Asset')->findAll();
        return array('assets' => $assets);
    }
}
