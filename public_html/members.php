<?php
require("page.php");
require_once("../upload/lib/TableMaker.php");
require_once("../upload/lib/PlayerHelper.php");

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
$content = <<< EOT
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
<div id="memberstable">
EOT;

// Get member's list
$ph = new PlayerHelper();
$players = $ph->GetMembersTableData();

//Create "Members" Table
$tm = new TableMaker();
$tm->headers = ["Member#", "Name", "Expires"];
$tm->caption = 	"Members<span class='smallcap'></span>";
$tm->tagId = "mt";
$tm->additionalClasses = "tablesorter";
$tm->data = $players;
$content .= $tm->GetTable();

$content .= <<< EOT
</div>
<div id="shortcaps"></div>
<div id="longcaps"></div>
</div>
EOT;

$page->content = $content;
// Display the page
$page->Display();
?>