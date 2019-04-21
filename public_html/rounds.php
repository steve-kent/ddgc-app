<?php
require("page.php");
require("../upload/lib/HandicapHelper.php");
require("MembersTables.php");

$roundId = 0;

//set roundID if this is a get request for it
if(isset($_GET['roundID']))
{
    $roundId = $_GET['roundID'];
}

// Set description and title
$desc = "View results of handicap rounds at Debary Disc Golf Club";
$title = "DeBary Disc Golf Club | Handicap results";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

// Add content
?>
<div id="container">
    <div id='roundList' class='hideAt660'>
        <?=ShowRoundsList()?>
    </div>
    <div id='displayRound'>
        <?=ShowRoundResults($roundId)?>
    </div>
</div>
<?php

//Write footer
AddFooter();

?>