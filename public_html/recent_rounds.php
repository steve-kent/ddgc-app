<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
require("MembersTables.php");

// Set description and title
$desc = "View results of handicap rounds at Debary Disc Golf Club. Click a round to view results.";
$title = "DeBary Disc Golf Club | Recent Handicap Rounds";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

// Add content
?>
<div id="container" class="centerStuff">
    <div id='roundList'>
        <?=ShowRoundsList()?>
    </div>
</div>
<?php

//Write footer
AddFooter();

?>