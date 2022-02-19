<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();
require('staticStuff.php');
require_once("../lib/validator.php");
require_once("../lib/EventHelper.php");

$eventId = 0;
$event = null;

//set roundID if this is a get request for it
if (isset($_GET['eventId'])) {
    $eventId = $_GET['eventId'];

    if ($eventId) {
        $event = EventHelper::GetEventById($eventId);
    }
}


// Set description and title
$desc = "Edit an upcoming event";
$title = "DeBary Disc Golf Club | Edit Event";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
if ($event) {
?>
    <div id="container">
        <?php WriteManageUserHeader(); ?>
        <div class='centerStuff'>
            <div style="display: inline-block;">
                <h2>Edit Event</h2>
                <form id="eventEvent" name="eventEvent" method="post" action="validateEditEvent.php">
                    <input type='hidden' id='eventId' name='eventId' value='<?= $event['EventID'] ?>'>
                    <label for="eventName">Event Name:</label> <input type="text" name="eventName" id="eventName" size="20" tabindex="1" accesskey="n" autocomplete="off" value='<?= FormatOutput($event['EventName']) ?>' autofocus> <br>
                    <?php if ($event['EventDate']) : ?>
                        <label for="eventDate">Event Date:</label> <input type="date" name="eventDate" id="eventDate" value='<?= FormatOutput($event['EventDate']) ?>'> <br>
                    <?php endif; ?>
                    <label for="eventInfo">Event Info:</label><br><textarea name="eventInfo" rows="10" cols="30"><?= $event['EventInformation'] ?></textarea> <br>
                    <label for="eventLink">Link (optional):</label> <input type="text" name="eventLink" id="eventLink" size="20" autocomplete="off" value='<?= FormatOutput($event['EventLink']) ?>' autofocus> <br>
                    <input type=submit name="saveChanges" value="Update Event">
                </form>
                <form id='deleteEvent' name='deleteEvent' method='post' action='validateEditEvent.php' onsubmit='return confirm("Are you sure you want to delete this event?")'>
                    <input type='hidden' id='eventId' name='eventId' value='<?= $event['EventID'] ?>'>
                    <input type=submit id='deleteEvent' name='deleteEvent' value='Delete Event'>
                </form>
            </div>
        </div>
    </div>
<?php
} else {
?>
    <h2>Event not Found!</h2>
    <p>Contact Steve Kent if you keep having issues.</p>
<?php
}
//Write footer
AddFooter();

?>