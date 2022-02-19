<?php 
if (!defined('ROOT_PATH'))
define('ROOT_PATH', dirname(__DIR__) . '/');
require_once(ROOT_PATH . "db/DbTalker.php");

class EventHelper
{
    public static function GetEventTypes()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetEventTypes();
    }

    public static function GetAllEvents()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetAllEvents();
    }

    public static function AddEvent($eventName, $eventDate, $eventInfo, $eventLink)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->AddEvent($eventName, $eventDate, $eventInfo, $eventLink);
    }

    public static function GetEventById($eventId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetEventById($eventId);
    }

    public static function UpdateEvent($eventId, $eventName, $eventDate, $eventInfo, $eventLink)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->UpdateEvent($eventId, $eventName, $eventDate, $eventInfo, $eventLink);
    }

    public static function DeleteEventById($eventId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->DeleteEventById($eventId);
    }
}

?>