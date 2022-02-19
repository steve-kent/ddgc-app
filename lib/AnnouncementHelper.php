<?php 
if (!defined('ROOT_PATH'))
define('ROOT_PATH', dirname(__DIR__) . '/');
require_once(ROOT_PATH . "db/DbTalker.php");

class AnnouncementHelper
{
    public static function GetAllAnnouncements()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetAllAnnouncements();
    }

    public static function AddAnnouncement($announcementTitle, $announcementInformation, $announcementLink)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->AddAnnouncement($announcementTitle, $announcementInformation, $announcementLink);
    }

    public static function GetAnnouncementById($announcementId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetAnnouncementById($announcementId);
    }

    public static function UpdateAnnouncement($announcementId, $announcementTitle, $announcementInformation, $announcementLink)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->UpdateAnnouncement($announcementId, $announcementTitle, $announcementInformation, $announcementLink);
    }

    public static function DeleteAnnouncementById($announcementId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->DeleteAnnouncementById($announcementId);
    }
}

?>