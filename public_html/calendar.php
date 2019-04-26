<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();

// Set description and title
$desc = "Calendar of Events for the DeBary Disc Golf Club and other local clubs";
$title = "DeBary Disc Golf Club | Calendar";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

// Add content
?>
<div id="container" style="display:table;">
    <div class="disc_pic">
        <img src="images/disc.jpg" alt="Disc stuck in the ground">
    </div>
    <div id="calendar_mobile">
        <iframe src="https://calendar.google.com/calendar/embed?mode=AGENDA&amp;height=500&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=brianroberts2526%40yahoo.com&amp;color=%236B3304&amp;ctz=America%2FNew_York"></iframe>
    </div>
    <div id="calendar_desktop">
        <iframe src="https://calendar.google.com/calendar/embed?height=500&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=brianroberts2526%40yahoo.com&amp;color=%236B3304&amp;ctz=America%2FNew_York"></iframe>
    </div>

</div>

<?php

//Write footer
AddFooter();


?>