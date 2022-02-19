<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require("../lib/AnnouncementHelper.php");
require_once("../lib/validator.php");


// echo(var_dump($_REQUEST));

$result = 0;
// Make sure this is coming from the form
if(isset($_POST['saveChanges']))
{
    $announcementId = $_POST['announcementId'];
    $announcementTitle = $_POST['announcementTitle'];
    $announcementInfo = $_POST['announcementInfo'];    
    $announcementLink = trim($_POST['announcementLink']) ?: null;

    $result = AnnouncementHelper::UpdateAnnouncement($announcementId, $announcementTitle, $announcementInfo, $announcementLink);
}
else if (isset($_POST['deleteAnnouncement']))
{
    $announcementId = $_POST['announcementId'];
    $result = AnnouncementHelper::DeleteAnnouncementById($announcementId);
}

//If the edit was added and we get the roundId, navigate to show the round.
if($result)
{
    header("Location: index.php");
    exit();
}
// If we don't get a round back show error.
else
{
    echo "There was a problem editing the event. Go back and try again";
    exit();
}

?>