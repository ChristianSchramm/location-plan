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
        // Absolut path
        $webPath = $this->get('kernel')->getRootDir() . '/../web/';
        $uploadPath = $webPath . '/upload/';

        $eventArray = array();
        foreach($events as $event)
        {
            $eventArray[] = $event->toArray();
        }

        // Delete old ZipArchiv
        if(is_file($filename))
        {
            unlink($filename);
        }

        // Create ZipArchive
        $zipArchiv = new \ZipArchive();
        if ($zipArchiv->open($webPath . 'zip/' . $filename, \ZipArchive::CREATE) !== TRUE)
        {
            throw $this->createNotFoundException('Zip file could not be created.');
        }

        // Create JSON-File
        $zipArchiv->addFromString('events.json', json_encode($eventArray));

        // Add related files
        foreach ($assets as $asset)
        {
            if(is_file($uploadPath.$asset->getSrc()))
            {
                $zipArchiv->addFile($uploadPath.$asset->getSrc(), $asset->getSrc());
            }
        }

        $zipArchiv->close();

        $this->getRequest()->getUriForPath($filename);

        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '"');
        $response->headers->set('Content-length', filesize($filename));

        // Send headers before outputting anything
        $response->sendHeaders();
        return $response->setContent(readfile($filename));
    }
}
