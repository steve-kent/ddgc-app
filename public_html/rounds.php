<?php
require("page.php");
require("../upload/db/DbTalker.php");
require("../upload/lib/HandicapHelper.php");

$roundId = 0;
$roundData = [];
$content = "";
$hh = new HandicapHelper();

//set roundID if this is a get request for it
if(isset($_GET['roundID']))
{
    $roundId = $_GET['roundID'];
}

//Get the round info from the DB and assign it if there is a roundID set
if($roundId)
{
    $roundData = $hh->GetHandicapRound($roundId);
}

// Create new page
$page = new Page();

// Set description and title
$page->desc = "View results of handicap rounds at Debary Disc Golf Club";
$page->title = "DeBary Disc Golf Club | Handicap results";

// Add content
$content = "<div id=\"container\">";

// If there are results from a round display a table with the results
if(count($roundData))
{
    $roundInfo = $hh->GetRoundCourseAndDate($roundId);
    $caption = $roundInfo[1] ." on ". $roundInfo[0];
    require_once("../upload/lib/TableMaker.php");
    $tm = new TableMaker();
    $tm->headers = ["Player","Raw Score", "Handicap", "Net Score"];
    $tm->caption = $caption;
    $tm->data = $roundData;
    $content .= $tm->GetTable();
}

$content .= "</div>";

$page->content = $content;

// Display the page
$page->Display();

?>