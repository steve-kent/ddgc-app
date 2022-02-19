<?php
require("page.php");
require_once("../lib/AuthHelper.php");
require_once("../lib/EventHelper.php");
require_once("components/card.php");
//Start session and update timeout
my_session_start();

// Set description and title
$desc = "Calendar of Events for the DeBary Disc Golf Club and other local clubs";
$title = "DeBary Disc Golf Club | Calendar";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

$upcomingEvents = array();
$weeklyEvents = array();

$allEvents = EventHelper::GetAllEvents();

foreach ($allEvents as $event) {
    if ($event["EventTypeName"] == "Weekly Events") {
        array_push($weeklyEvents, $event);
    }
    // Only get event if it's today or later.
    else if ($event["EventTypeName"] == "Upcoming Events" && strtotime($event['EventDate']) >= strtotime("today")) {
        array_push($upcomingEvents, $event);
    }
}


// $handicaps = array("Handicaps", "When: Saturdays - Last Entry 3pm\nCost: $10 standard all in. $5 If you haven't established a handicap. Add an additional $1 for PDGA rated round.");
// $doubles = array("Doubles", "When: Mondays - Last entry 3:30pm\nCost: $10\nRandom draw except 1st Monday of the month is bring your own partner.");

// array_push($weeklyEvents, $handicaps, $doubles);

// Add content
?>
<div id="container">
    <div class="centerStuff">
        <?php if (!empty($upcomingEvents)) : ?>
            <h2>Upcoming events</h2>
            <div class="card-group">
                <?php foreach ($upcomingEvents as $event) : ?>
                    <div class="col-full-2">
                        <?php
                        $date = date_create($event['EventDate']);
                        $dateString = date_format($date, "F jS Y");
                        $editLink = "edit_event.php?eventId=" . $event['EventID'];
                        createCard($event['EventName'], $event['EventInformation'], $editLink, $event['EventLink'], $dateString)

                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <br>
        <?php endif; ?>
        <h2>Weekly Club Events</h2>
        <h5 class="m-0">All Members and Non-Members are Welcome</h5>
        <div class="card-group">
            <?php foreach ($weeklyEvents as $event) : ?>
                <div class="col-full-2">
                    <?php
                    $date = date_create($event['LastUpdated']);
                    $dateString = "Last Updated " . date_format($date, "F jS Y");
                    $editLink = "edit_event.php?eventId=" . $event['EventID'];
                    createCard($event['EventName'], $event['EventInformation'], $editLink, $event['EventLink'],  $dateString);
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php

//Write footer
AddFooter();


?>