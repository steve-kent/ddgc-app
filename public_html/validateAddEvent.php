<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require_once("../lib/EventHelper.php");
$eventId = 0;

// If it was submitted, add the new event.
if(isset($_POST['addEvent']))
{
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventInfo = $_POST['eventInfo'];    
    $eventLink = trim($_POST['eventLink']) ?: null;

    $roundId = EventHelper::AddEvent($eventName, $eventDate, $eventInfo, $eventLink);
}

//If the event was added, got to the calendar page.
if($roundId)
{
    header("Location: calendar.php");
    exit();
}

// Show error message if it wasn't added.
else
{
    echo "There was a problem adding the event. Go back and try again";
    exit();
}

?>