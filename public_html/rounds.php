<?php
require("page.php");
require("../upload/lib/HandicapHelper.php");
require('../upload/lib/LinkedTableMaker.php');

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

//Get list of rounds
$roundsList = $hh->Get50Rounds(0);

// Add List of rounds to a pane on the right side
$content .= "<div id='roundList' class='hideAt660'>";
$ltm =  new LinkedTableMaker();
$ltm->headers = ["Round Date", "Course"];
$ltm->caption = "Recent Rounds<br><span class='smallcap'>Click to View Results</span>";
$ltm->data = $roundsList;
$ltm->rowLink = "rounds.php?roundID=";
$content .= $ltm->GetTable();
$content .= "</div>";




// If there are results from a round display a table with the results
$content .= "<div id='displayRound'>";
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
$content .= "</div></div>";

$page->content = $content;

// Display the page
$page->Display();

?>