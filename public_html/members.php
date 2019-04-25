<?php
require("page.php");
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
<div class="centerStuff"><div class="button halfSize"><a href="rounds.php">View Handicap Results</a></div></div>
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
        <?=ShowMembersTable()?>
</div>
<div id="shortcaps">
<?=ShowShortPadsTable()?>
</div>
<div id="longcaps">
<?=ShowLongPadsTable()?>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/jquery.tablesorter.js"></script>
<script src="js/loadertest.js"></script>

<?php

//Write footer
AddFooter();
?>