<?php
require("page.php");
require("../upload/db/DbTalker.php");
require('staticStuff.php');

// Create new page
$page = new Page();

//Get All Names List for Autofill
$dbTalker = new DbTalker();
$nameList =  $dbTalker->GetNamesAndNicks();
$courseList = $dbTalker->GetCourseNames();

// Set description and title
$page->desc = "Add Scores for a Handicap Round information for DeBary Disc Golf Club.";
$page->title = "DeBary Disc Golf Club | Enter Handicap Round Scores";

$headAdditions = <<< EOT
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='js/scoreHandis.js'></script>
EOT;


$page->headAdditions = $headAdditions;

// Add content
// Create Form for inputting scores
$content = <<< EOT
<div id="container">$manageUserHeader<div class="centerStuff"><div class="formContainer">
<div class="centerStuff">
<form name="scoreRound" method="post" action="doScoring.php">
<div id="scoreRoundHeading">Score a Handicap Round:<br>
<br><span id='courseSelection'>Course: <select name="course" id="course" tabindex="1" accesskey="c"> 
<option value=''></option>
EOT;

foreach ($courseList as $course)
{
    $content .= "<option value=\"$course\">$course</option>";
}

$content .= <<< EOT
        </select></span><br><br>
    <span class='nowrap'>Date: <input type="date" id="roundDate" name="roundDate"
EOT;
// Set default date on the date picker to today
$content .= 'value="';
$content .= date("Y-m-d");
$content .='"></span></div><br>';

$content .= <<< EOT
<table id="scoreHandis" align=center autocomplete="off">
    <tr id="row1">
        <td>Name: <input type="text" name="name[]" class='autoName' size='15' autofocus></td> 
        <td>Raw Score: <input type="number" name="score[]" min="1" max="200" value="54" scoreField></td> 
    <br>   
    </table>
    <input type="button" class="button" value="Add Player" onclick="add_row()">
    <input type="submit" name="submitRound" value="Score Round">
    </form>
    </div></div></div></div>
EOT;

// Setup Autofill for name input box
$content .= "<script>AddNames(";
$content .= json_encode($nameList);
$content .= ")</script><br>";
$content .= "<script>AddCourses(";
$content .= json_encode($courseList);
$content .= ")</script><br>";
$content .= "<script>AddAutoFill()</script>";

$page->content = $content;

// Display the page
$page->Display();
?>