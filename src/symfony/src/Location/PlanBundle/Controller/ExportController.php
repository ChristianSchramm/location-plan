<?php

namespace Location\PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ExportController extends Controller
{
    /**
     * @Route("/export/json")
     * @Template()
     */
    public function jsonAction()
    {
    }

    /**
     * @Route("/export/download")
     * @Template()
     */
    public function downloadAction()
    {
    }

}
