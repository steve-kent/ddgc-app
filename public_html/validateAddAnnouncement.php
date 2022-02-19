<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require_once("../lib/AnnouncementHelper.php");
$eventId = 0;

// If it was submitted, add the new event.
if(isset($_POST['addAnnouncement']))
{
    $announcementTitle = $_POST['announcementTitle'];
    $announcementInfo = $_POST['announcementInfo'];    
    $announcementLink = trim($_POST['announcementLink']) ?: null;

    $eventId = AnnouncementHelper::AddAnnouncement($announcementTitle, $announcementInfo, $announcementLink);
}

//If the event was added, got to the calendar page.
if($eventId)
{
    header("Location: index.php");
    exit();
}

// Show error message if it wasn't added.
else
{
    echo "There was a problem adding the announcement. Go back and try again. If you keep having issues, contact Steve Kent.";
    exit();
}

?>