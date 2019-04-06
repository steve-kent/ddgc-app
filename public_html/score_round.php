<?php
require("page.php");
require("../upload/db/DbTalker.php");

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


/*
// Script to Do autofill with JQuery UI
$headAdditions .= <<< EOT
<script>

$(function() {
var availableTags =
EOT;

$headAdditions .= json_encode($nameList);

$headAdditions .= <<< EOT
;
console.log(availableTags + " is tags");
    $( "#name1" ).autocomplete({
    source: availableTags
    });
});

</script>
EOT;
*/


$page->headAdditions = $headAdditions;

// Add content
// Create Form for inputting scores
$content = <<< EOT
<div id="container">
    <form name="scoreRound" method="post" action="doScoring.php">
    Score a Handicap Round:<br>
    Course: <select name="course" id="course" tabindex="1" accesskey="c"> 
EOT;

foreach ($courseList as $course)
{
    $content .= "<option value=\"$course\">$course</option>";
}

$content .= <<< EOT
        </select>
    Date: <input type="date" id="roundDate" name="roundDate"
EOT;
// Set default date on the date picker to today
$content .= 'value="';
$content .= date("Y-m-d");
$content .='"><br>';

$content .= <<< EOT
<table id="scoreHandis" align=center autocomplete="off">
    <tr id="row1">
        <td>Name: <input type="text" name="name[]" class='autoName' size='15'></td> 
        <td>Raw Score: <input type="number" name="score[]" min="1" max="200" value="54" scoreField></td> 
    <br>   
    </table>
    <input type="button" class="button" value="Add Player" onclick="add_row()">
    <input type="submit" name="submitRound" value="Score Round">
    </form>
    </div>
EOT;

// Setup Autofill for name input box
$content .= "<script>AddNames(";
$content .= json_encode($nameList);
$content .= ")</script><br>";
$content .= "<script>AddAutoFill()</script>";

$page->content = $content;

// Display the page
$page->Display();
?>