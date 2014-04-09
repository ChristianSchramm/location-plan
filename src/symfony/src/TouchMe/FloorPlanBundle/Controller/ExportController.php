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
        $assets = $em->getRepository('TouchMeFloorPlanBundle:Asset')->findAll();
        
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
            // Create JSON-File
            $eventArray = array();
            foreach($events as $event)
            {
                $eventArray[] = $event->toArray();
            }
            $zipArchiv->addFromString('events.json', json_encode($eventArray));

            // Add related files
            foreach ($assets as $asset)
            {
                if ($fs->exists($uploadPath . $asset->getSrc()))
                {
                    $zipArchiv->addFile($uploadPath . $asset->getSrc(), $asset->getSrc());
                }
            }

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
