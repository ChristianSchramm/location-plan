<?php

namespace TouchMe\FloorPlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class jsonController extends Controller
{

    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('TouchMeFloorPlanBundle:Event')->findAll();
        $assets = $em->getRepository('TouchMeFloorPlanBundle:Asset')->findAll();

        // Location of zip file relativ to web folder
        $filename = "zip/event.zip";

        // Absolut path
        $uploadPath = str_replace("app", "web/upload/", $this->get('kernel')->getRootDir());
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
        $zipArchiv->open($filename, \ZipArchive::CREATE);

        // Create JSON-File
        $zipArchiv->addFromString("events.json", json_encode($eventArray));

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
