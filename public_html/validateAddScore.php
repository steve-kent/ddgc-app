<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require_once("../lib/HandicapHelper.php");
$roundId = 0;

//If a new round was just scored, submit it and get the roundID
if(isset($_POST['addScore']))
{
    $courseName = $_POST['courseName'];
    $player = $_POST['name'];
    $score = $_POST['score'];
    $roundId = $_POST['roundId'];

    $hh = new HandicapHelper();
    $roundId = $hh->InsertScore($courseName, $roundId, $player, $score);
}

//If the scoring was completed and we get the roundId, navigate to show the round.
if($roundId)
{
    header("Location: rounds.php?roundID=$roundId");
    exit();
}

// If we don't get a round back just go back to the score round page.
else
{
    //header("Location: add_score.php");
    //timtexit();
}

?>