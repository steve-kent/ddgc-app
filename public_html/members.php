<?php
require("page.php");

// Create new page
$page = new Page();

// Set description and title
$page->desc = "Handicaps and Membership information for DeBary Disc Golf Club.";
$page->title = "DeBary Disc Golf Club | Members";

$page->headAdditions = <<< EOT
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/jquery.tablesorter.js"></script>
<script src="js/loadertest.js"></script>
EOT;

// Add content
$page->content = <<< EOT
<div id="container">
<div id="members_nav">
        <div class="button"><a href="join.php">Join the club</a></div>
        <div class="button" id="memberslist_button">Members List</div>
        <div class="button" id="shortcaps_button">Short Pad Handicaps</div>
        <div class="button" id="longcaps_button">Long Pad Handicaps</div>
</div>
    
<div class="playing">
<img src="images/playing.jpg" alt="Player throwing a disc" >
</div>
    
<div id="memberstable"></div>
<div id="shortcaps"></div>
<div id="longcaps"></div>
</div>
EOT;

// Display the page
$page->Display();
?>