<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();
require('staticStuff.php');




// Set description and title
$desc = "Add an upcoming event";
$title = "DeBary Disc Golf Club | Add Event";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
?>
<div id="container">
    <?php WriteManageUserHeader(); ?>
    <div class='centerStuff'>
        <h2>Add Upcoming Event</h2>
        <form id="addEvent" name="addEvent"  method="post" action="validateAddEvent.php"> 
        <label for="eventName">Event Name:</label> <input type="text" name="eventName" id="eventName" size="20" tabindex="1" autocomplete="off" autofocus> <br> 
        <label for="eventDate">Event Date:</label> <input type="date" name="eventDate" id="eventDate"> <br>
        <label for="eventInfo">Event Info:</label><br><textarea name="eventInfo" rows="10" cols="30" autocomplete="off"></textarea> <br>
        <label for="eventLink">Link:</label> <input type="text" name="eventLink" id="eventLink" size="20" autocomplete="off"> <br> 
        <input type=submit name="addEvent" value="Submit">
        </form>        
    </div>
</div>

<?php

//Write footer
AddFooter();

?>