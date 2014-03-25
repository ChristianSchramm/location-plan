<?php

namespace TouchMe\FloorPlanBundle\Utilities;

use TouchMe\FloorPlanBundle\Entity\Event;
use TouchMe\FloorPlanBundle\Entity\Asset;
use TouchMe\FloorPlanBundle\Entity\Location;

class Utility
{
  /**
   * Removes all entires in DB
   * @param  EntityManager $em
   */
  public static function clearDB($em)
  {
    $connection = $em->getConnection();
    $platform = $connection->getDatabasePlatform();
    $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
    $connection->executeUpdate($platform->getTruncateTableSQL('event_asset', true));
    $connection->executeUpdate($platform->getTruncateTableSQL('event', true));
    $connection->executeUpdate($platform->getTruncateTableSQL('location', true));
    $connection->executeUpdate($platform->getTruncateTableSQL('asset', true));
    $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
  }

  /**
   * Insert all given events (and their data) into DB
   * @param  array $events
   * @param  EntityManager $em
   */
  public static function insertIntoDB($events, $em)
  {
    foreach ($events as $event)
    {
      $eventObj = new Event();
      $eventObj->setTitle($event['title']);
      $eventObj->setPersonincharge($event['personincharge']);
      $eventObj->setDescription($event['description']);
      $eventObj->setBranchofstudy($event['branchofstudy']);
      $eventObj->setStarttime(\DateTime::createFromFormat("Y-m-d H:i:s", $event['starttime']['date']));
      $eventObj->setEndtime(\DateTime::createFromFormat("Y-m-d H:i:s", $event['endtime']['date']));

      $locationObj = new Location();
      $locationObj->setDescription($event["location"]["description"]);
      $locationObj->setNumber($event["location"]["number"]);
      $locationObj->setType($event["location"]["type"]);

      $em->persist($locationObj);
      $eventObj->setLocation($locationObj);

      foreach ($event["assets"] as $asset)
      {
        $assetObj = new Asset();
        $assetObj->setTitle($asset["title"]);
        $assetObj->setSrc($asset["src"]);

        $em->persist($assetObj);
        $eventObj->addAsset($assetObj);
      }

      $em->persist($eventObj);
      $em->flush();
    }
  }
}