<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();

require("MembersTables.php");


// Set description and title
$desc = "Handicaps and Membership information for DeBary Disc Golf Club.";
$title = "DeBary Disc Golf Club | Members";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

// Add content
?>
<div id="container">
<div class="centerStuff"><div class="button halfSize"><a href="recent_rounds.php">View Handicap Results</a></div></div>
<div id="members_nav">
        <div class="button"><a href="join.php">Join the club</a></div>
        <div class="button" id="memberslist_button">Members List</div>
        <div class="button" id="shortcaps_button">Short Pad Handicaps</div>
        <div class="button" id="longcaps_button">Long Pad Handicaps</div>
        <div class="button" id="warcaps_button">War Qual Handicaps</div>
        <div class="button" id="fnscaps_button">Friday Night Shorties</div>
</div>
<div class="playing">
<img src="images/playing.jpg" alt="Player throwing a disc" >
</div>
<div id="memberstable" class="members-table">
        <?=ShowMembersTable()?>
</div>
<div id="shortcaps" class="members-table">
<?=ShowShortPadsTable()?>
</div>
<div id="longcaps" class="members-table">
<?=ShowLongPadsTable()?>
</div>
<div id="warcaps" class="members-table">
<?=ShowWarLayoutTable()?>
</div>
<div id="fnscaps" class="members-table">
<?=ShowFridayNightShortiesTable()?>
</div>
</div>

<?php
    LoadjQuery();
?>

<script src="js/jquery.tablesorter.js"></script>
<script src="js/loadertest.js"></script>

<?php

//Write footer
AddFooter();
?>