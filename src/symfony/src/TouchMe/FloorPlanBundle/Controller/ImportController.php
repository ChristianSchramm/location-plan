<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use TouchMe\FloorPlanBundle\Utilities\Utility;

class ImportController extends Controller
{
  public function indexAction(Request $request)
  {
    // Check if ZIP via POST transmitted
    if ($request->isMethod('POST'))
    {
      $uploadedFile = $request->files->get('backup');

      // Check if file is ZIP
      if ($uploadedFile->guessExtension() === "zip")
      {
        $json       = '';
        $backupPath = 'backup';
        $backupFile = '/backup.zip';
        $uploadPath = 'upload';
        $em         = $this->getDoctrine()->getManager();
        $fs         = new Filesystem();
        $finder     = new Finder();

        if (!$fs->exists($uploadPath))
        {
          $fs->mkdir($uploadPath);
        }
        if (!$fs->exists($backupPath))
        {
          $fs->mkdir($backupPath);
        }

        // Save the uploaded ZIP file
        $uploadedFile->move($backupPath, $backupFile);

        // Extract $backupFile to $backupPath/imports
        $zip = new \ZipArchive();
        $zip->open($backupPath . $backupFile);
        $zip->extractTo($backupPath . '/imports');
        $zip->close();

        $finder->in($backupPath)->name('events.json');
        foreach ($finder as $file)
        {
          $json .= $file->getContents();
        }

        //$events = json_decode($json, TRUE);
        Utility::clearDB($em);
        Utility::insertIntoDB(json_decode($json, TRUE), $em);

        // Copie all files and directories from $backupPath/imports to $uploadPath
        $fs->mirror($backupPath . '/imports', $uploadPath);

        // Removes $backupPath directory
        $fs->remove($backupPath);

        // Generate a flash message
        $this->get('session')->getFlashBag()->add('notice', 'Die Daten wurden erfolgreich importiert.');
        
        //return $this->render("TouchMeFloorPlanBundle:Default:import.html.twig");
        // Redirect to "/"
        return $this->redirect($this->generateUrl('touch_me_floor_plan_homepage'));
      }
      else
      {
        throw new FileException();
      }
    }

    return $this->render("TouchMeFloorPlanBundle:Default:import.html.twig");
  }
}