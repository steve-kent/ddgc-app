<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();
require('staticStuff.php');




// Set description and title
$desc = "Add an announcement";
$title = "DeBary Disc Golf Club | Add Announcement";

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
        <h2>Add An Announcement</h2>
        <form id="addAnnouncement" name="addAnnouncement"  method="post" action="validateAddAnnouncement.php"> 
        <label for="announcementTitle">Announcement Name:</label> <input type="text" name="announcementTitle" id="announcementTitle" size="20" tabindex="1" autocomplete="off" autofocus> <br>        
        <label for="announcementInfo">Announcement Info:</label><br><textarea name="announcementInfo" rows="10" cols="30" autocomplete="off"></textarea> <br>
        <label for="announcementLink">Link:</label> <input type="text" name="announcementLink" id="announcementLink" size="20" autocomplete="off"> <br> 
        <input type=submit name="addAnnouncement" value="Submit">
        </form>        
    </div>
</div>

<?php

//Write footer
AddFooter();

?>