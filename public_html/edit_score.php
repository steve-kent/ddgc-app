<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require("page.php");
require_once("../lib/HandicapHelper.php");
require_once("../lib/validator.php");
require('staticStuff.php');


$scoreId = 0;
$scoreInfo = null;
$hh = new HandicapHelper();

//set roundID if this is a get request for it
if(isset($_GET['scoreId']))
{
    $playerId = $_GET['scoreId'];
}

//Get the round info from the DB and assign it if there is a roundID set
if($scoreId)
{
    $scoreInfo = $hh->GetHandicapScoreInfo($scoreId);
}

// Set description and title
$desc = "Edit Score";
$title = "DeBary Disc Golf Club | Edit Score for Player";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
?>
<div id="container">

<?php 
WriteManageUserHeader(); 

?>
<div id='playerFormContainer'>
    <div id='playerInfo'>
        <h3>Edit Players Score</h3><br>
<?php

// If vaild player was in paramater show it in the edit form
if($score)
{
    ?>
    <form id='editPlayer' name='editPlayer' method='post' action='validateEditScore.php' onsubmit='return validateForm()'>
    <input type='hidden' id='playerId' name='scoreId' value='<?=$player['scoreID']?>'>
    Player: <input type='text' name='player' id='player' size='18' tabindex='1' accesskey='p' value='<?=FormatOutput($score[1])?>' readonly> <br> 
    Raw Score: <input onkeyup="upadateNetScore()" type='number' name='rawScore' id='rawScore' accesskey='r' value='<?=FormatOutput($score[2])?>'> <br> 
    Handicap: <input onkeyup="upadateNetScore()" type='number' name='handicap' id='handicap' accesskey='h' value='<?=FormatOutput($score[3])?>'> <br>
    Net Score#: <input type='number' name='netScore' id='netScore' accesskey='n' value='<?=FormatOutput($score[4])?>' readonly> <br>  
    <input type=submit id='saveChanges' name='saveChanges' value='Save Changes'>
    
    </form>
    <?php
}
?>
</div></div></div>

<?php
    LoadjQuery();
?>
<script src='js/editScore.js'></script>
<?php
//Write footer
AddFooter();
?>