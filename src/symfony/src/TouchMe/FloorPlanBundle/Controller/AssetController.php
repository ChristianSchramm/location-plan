<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TouchMe\FloorPlanBundle\Entity\Asset;

class AssetController extends Controller
{

  public function indexAction()
  {
    // Gets all Assets
    $assets = $this->getDoctrine()->getRepository('TouchMeFloorPlanBundle:Asset')->findAll();

    // Edit the src path so that the file could be displayed
    foreach ($assets as $asset) {
        $asset->setSrc('/upload/' . $asset->getSrc());
    }
    
    return $this->render('TouchMeFloorPlanBundle:Asset:index.html.twig', array('assets' => $assets));
  }

  public function uploadAction(Request $request)
  {
    $asset = new Asset();
    // Creates new form for an Asset object
    $form = $this->createFormBuilder($asset)
            ->add('title', 'text')
            ->add('file', 'file')
            ->add('Speichern', 'submit')
            ->getForm();

    // Inspects the given request and calls {@link submit()} if the form was submitted.
    $form->handleRequest($request);
    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      // Save Asset to DB
      $em->persist($asset);
      $em->flush();

      // Generate a flash message
      $this->get('session')->getFlashBag()->add('notice', 'Die Datei wurde erfolgreich hochgeladen.');
      // Redirect to /admin/asset - that shows all assets
      return $this->redirect($this->generateUrl('asset_show'));
    }

    // Create a form for an Asset if there was no form submitted
    return $this->render('TouchMeFloorPlanBundle:Asset:new.html.twig', array('form' => $form->createView()));
  }
  
  public function removeAction(Request $request, $id = null)
  {
    // Create a new delete form
    $form = $this->createFormBuilder()
      ->setAction($this->generateUrl('asset_remove'))
      ->add('id', 'hidden', array('data' => $id))
      ->add('Löschen', 'submit')
      ->getForm();
    
    // Inspects the given request and calls {@link submit()} if the form was submitted.
    $form->handleRequest($request);
    if ($form->isValid())
    {
      $doctrine = $this->getDoctrine();
      // Get asset with committed id
      $asset = $doctrine->getRepository('TouchMeFloorPlanBundle:Asset')->findOneBy(array('id' => $form->get('id')->getData()));
      if (!empty($asset)) {
        // Delete this asset
        $doctrine->getManager()->remove($asset);
        $doctrine->getManager()->flush();
        // Generate a flash message
        $this->get('session')->getFlashBag()->add('notice', 'Die Datei wurde gelöscht.');
      }
      else
      {
        // Generate a flash message
        $this->get('session')->getFlashBag()->add('notice', 'Die Datei konnte nicht gelöscht werden.');
      }

      // Redirect to /admin/asset - that shows all assets
      return $this->redirect($this->generateUrl('asset_show'));
    }
    
    // Create a form (delete button) if there was no form submitted
    return $this->render('TouchMeFloorPlanBundle:Asset:_del.html.twig', array('form' => $form->createView()));
  }

}
