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
  public static function importEventsIntoDB($events, $em)
  {
    foreach ($events as $event)
    {
      $eventObj = new Event();
      $eventObj->setTitle($event['title']);
      $eventObj->setPersonincharge($event['personincharge']);
      $eventObj->setDescription(
        array_key_exists('description', $event) ? $event['description'] : '');
      $eventObj->setBranchofstudy($event['branchofstudy']);
      $eventObj->setStartdate($event['startdate']);
      $eventObj->setStarttime($event['starttime']);
      $eventObj->setEnddate($event['enddate']);
      $eventObj->setEndtime($event['endtime']);

      $locationObj = new Location();
      $locationObj->setDescription(
        array_key_exists('description', $event['location']) ? $event['location']['description'] : '');
      $locationObj->setNumber(
        array_key_exists('number', $event['location']) ? $event['location']['number'] : '');
      $locationObj->setType(
        array_key_exists('type', $event['location']) ? $event['location']['type'] : '');
      $locationObj->setVisible(
        array_key_exists('visible', $event['location']) ? $event['location']['visible'] : false);

      $em->persist($locationObj);
      $eventObj->setLocation($locationObj);

      foreach ($event['assets'] as $asset)
      {
        $assetObj = new Asset();
        $assetObj->setTitle($asset['title']);
        $assetObj->setSrc($asset['src']);

        $em->persist($assetObj);
        $eventObj->addAsset($assetObj);
      }

      $em->persist($eventObj);
    }
    
    $em->flush();
  }
  
  /**
   * Insert all given locations into DB
   * @param  array $locations
   * @param  EntityManager $em
   */
  public static function importLocationsIntoDB($locations, $em)
  {
    foreach ($locations as $location)
    {
      $locationObj = new Location();
      $locationObj->setDescription(
        array_key_exists('description', $location) ? $location['description'] : '');
      $locationObj->setNumber(
        array_key_exists('number', $location) ? $location['number'] : '');
      $locationObj->setType(
        array_key_exists('type', $location) ? $location['type'] : '');
      $locationObj->setVisible(
        array_key_exists('visible', $location) ? $location['visible'] : false);
      
      $em->persist($locationObj);
    }
    
    $em->flush();
  }

}