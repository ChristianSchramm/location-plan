<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TouchMe\FloorPlanBundle\Entity\Asset;

class AssetController extends Controller
{

  public function indexAction()
  {
    $assets = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Asset')->findAll();

    foreach ($assets as $asset) {
        $asset->setSrc('/upload/' . $asset->getSrc());
    }
    return $this->render('TouchMeFloorPlanBundle:Asset:index.html.twig', array('assets' => $assets));
  }

  public function uploadAction(Request $request)
  {
    $asset = new Asset();
    $form = $this->createFormBuilder($asset)
            ->add('title', 'text')
            ->add('file', 'file')
            ->add('Speichern', 'submit')
            ->getForm();

    $form->handleRequest($request);
    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();

      $em->persist($asset);
      $em->flush();

      return $this->redirect($this->generateUrl('touch_me_floor_plan_homepage'));
    }

    return $this->render('TouchMeFloorPlanBundle:Asset:new.html.twig', array('form' => $form->createView()));
  }

}
