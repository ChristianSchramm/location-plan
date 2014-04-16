<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;

class ExportController extends Controller
{

    public function indexAction()
    {
        $filename = 'event.zip';
        $fs = new Filesystem();
        $em = $this->getDoctrine();
        $events = $em->getRepository('TouchMeFloorPlanBundle:Event')->findAll();
        
        // Absolute paths
        $webPath = $this->get('kernel')->getRootDir() . '/../web/';
        $uploadPath = $webPath . 'upload/';
        $zipPath = $webPath . 'zip/';

        if (!$fs->exists($zipPath))
        {
            $fs->mkdir($zipPath);
        }

        // Create ZipArchive or overwrite old one
        $zipArchiv = new \ZipArchive();
        if ($zipArchiv->open($zipPath . $filename, \ZipArchive::CREATE | \ZIPARCHIVE::OVERWRITE) === TRUE)
        {   
            $locationDiff = array();
            $exportArray = array();
            foreach ($events as $key => $event)
            {
              // Serialize object
              $exportArray[0][$key] = $event->toArray();
              
              // Locations that are already stored
              $locationDiff[] = $exportArray[0][$key]['location']['id'];
              
              // Add related files
              foreach ( $exportArray[0][$key]['assets'] as $asset)
              {
                  if ($fs->exists($uploadPath . $asset['src']))
                  {
                      $zipArchiv->addFile($uploadPath . $asset['src'], $asset['src']);
                  }
              }
            }
            
            // Find and serialize locations that are not yet stored
            $locations = $em->getRepository('TouchMeFloorPlanBundle:Location')->findAllExept($locationDiff);
            foreach ($locations as $id => $location)
            {
                $exportArray[1][$id] = $location->toArray();
            }
            
            // Create JSON-File
            $zipArchiv->addFromString('events.json', json_encode($exportArray));

            if ($zipArchiv->close())
            {
                // prepare BinaryFileResponse
                $response = new BinaryFileResponse($zipPath . $filename);
                $response->trustXSendfileTypeHeader();
                $response->setContentDisposition(
                    ResponseHeaderBag::DISPOSITION_INLINE, $filename, iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
                );

                $response->prepare(Request::createFromGlobals());
                $response->send();
                
                return $response;
            }
            else
            {
                throw $this->createNotFoundException('Zip file could not be written.');
            }
        }
        else
        {
            throw $this->createNotFoundException('Zip file could not be created.');
        }


    }
}
