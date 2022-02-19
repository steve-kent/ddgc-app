<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require("../lib/EventHelper.php");
require_once("../lib/validator.php");




$result = 0;
// Make sure this is coming from the form
if(isset($_POST['saveChanges']))
{
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventInformation = htmlspecialchars($_POST['eventInfo']);
    $eventId = $_POST['eventId'];
    $eventLink = trim($_POST['eventLink']) ?: null;

    $result = EventHelper::UpdateEvent($eventId, $eventName, $eventDate, $eventInformation, $eventLink);
}
else if (isset($_POST['deleteEvent']))
{
    $eventId = $_POST['eventId'];
    $result = EventHelper::DeleteEventById($eventId);
}

//If the edit was added and we get the roundId, navigate to show the round.
if($result)
{
    header("Location: calendar.php");
    exit();
}
// If we don't get a round back show error.
else
{
    echo "There was a problem editing the event. Go back and try again";
    exit();
}

?>