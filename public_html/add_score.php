<?php
/********COULD SEPERATE CONCERNS ON THIS PAGE *****************/
require_once("page.php");
require_once("../lib/AuthHelper.php");
require_once("../lib/HandicapHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require_once("../db/DbTalker.php");
require_once('staticStuff.php');

//Get All Names List for Autofill
$dbTalker = new DbTalker();
$nameList =  $dbTalker->GetNamesAndNicks();

// Set description and title
$desc = "Add Score for a player to Handicap Round for DeBary Disc Golf Club.";
$title = "DeBary Disc Golf Club | Add Player's Score to round";

//Turn off indexing 
$shouldIndex = 0;

$roundId = 0;

//set roundID if this is a get request for it
if(isset($_GET['roundID']))
{
    $roundId = $_GET['roundID'];
}

//Create page title heading
$hh = new HandicapHelper();
$roundInfo = $hh->GetRoundCourseAndDate($roundId);
$pageTitle = "Add score for ". $roundInfo[1] ." on <span class='nowrap'>". $roundInfo[0] ."</span>";

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
// Create Form for inputting scores
?>
<div id="container">
    <?=WriteManageUserHeader()?>
    <div class="centerStuff">
        <div class="formContainer">
            <div class="centerStuff">
                <form name="scoreRound" method="post" autocomplete="off" action="validateAddScore.php" onsubmit="isLastLineValid()">
                <input type='hidden' id='roundId' name='roundId' value='<?=$roundId?>'>
                <input type='hidden' id='courseName' name='courseName' value='<?=$roundInfo[1]?>'>
                <div id="scoreRoundHeading"><?=$pageTitle?><br><br>
                <table id="scoreHandis">
                    <tr id="row1">
                        <td>Name: <input type="text" name="name" class='autoName' size='15' autofocus></td> 
                        <td>Raw Score: <input type="number" name="score" min="1" max="200" value="54"></td>
                    </tr>
                </table>
                <input type="submit" name="addScore" value="Add Score to Round">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    LoadjQueryUI()
?>
<script src='js/scoreHandis.js'></script>
<script>AddNames(<?=json_encode($nameList)?>)</script><br>
<script>AddAutoFill()</script>

<?php

//Write footer
AddFooter();
?>