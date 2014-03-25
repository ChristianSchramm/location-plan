<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{

    public function indexAction(Request $request)
    {
        $filename = 'event.zip';
        $em = $this->getDoctrine();

        $events = $em->getRepository('TouchMeFloorPlanBundle:Event')->findAll();
        $assets = $em->getRepository('TouchMeFloorPlanBundle:Asset')->findAll();
        // Absolute paths
        $webPath = $this->get('kernel')->getRootDir() . '/../web/';
        $uploadPath = $webPath . 'upload/';
        $zipPath = $webPath . 'zip/';

        if (!is_dir($webPath . 'zip'))
        {
            mkdir($webPath . 'zip/');
        }

        $eventArray = array();
        foreach($events as $event)
        {
            $eventArray[] = $event->toArray();
        }

        // Create ZipArchive or overwrite old one
        $zipArchiv = new \ZipArchive();
        if ($zipArchiv->open($zipPath . $filename, \ZipArchive::CREATE | \ZIPARCHIVE::OVERWRITE) === TRUE)
        {
            // Create JSON-File
            $zipArchiv->addFromString('events.json', json_encode($eventArray));

            // Add related files
            foreach ($assets as $asset)
            {
                if(is_file($uploadPath . $asset->getSrc()))
                {
                    $zipArchiv->addFile($uploadPath . $asset->getSrc(), $asset->getSrc());
                }
            }

            if ($zipArchiv->close())
            {
                //$response = new Response();
                $response = new Response(readfile($zipPath . $filename));

                // Set headers
                $response->headers->set('Cache-Control', 'private');
                $response->headers->set('Content-type', mime_content_type($zipPath . $filename));
                $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '"');
                $response->headers->set('Content-length', filesize($zipPath . $filename));

                // Send headers before outputting anything
                $response->sendHeaders();
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
