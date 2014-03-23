<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AssetController extends Controller
{
  public function indexAction($name)
  {
    return $this->render('TouchMeFloorPlanBundle:Default:index.html.twig', array('name' => $name));
  }

  public function uploadAction(Request $request)
  {
    $asset = new Asset();
    $form = $this->createFormBuilder($asset)->add('title')->add('file')->getForm();
    $form->handleRequest($request);
    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();

      $asset->upload();

      $em->persist($asset);
      $em->flush();

      return $this->redirect($this->generateUrl('/'));
    }

    return array('form' => $form->createView());
  }
}
