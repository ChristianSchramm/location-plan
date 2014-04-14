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
            $eventArray = array();
            foreach ($events as $key => $event) {
              // Serialize object
              $eventArray[$key] = $event->toArray();
              // Add related files
              foreach ( $eventArray[$key]['assets'] as $asset)
              {
                if ($fs->exists($uploadPath . $asset['src']))
                {
                    $zipArchiv->addFile($uploadPath . $asset['src'], $asset['src']);
                }
              }
            }
            
            // Create JSON-File
            $zipArchiv->addFromString('events.json', json_encode($eventArray));

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
