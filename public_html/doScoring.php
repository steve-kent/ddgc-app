<?php
require("../upload/lib/HandicapHelper.php");
require("../upload/lib/AuthHelper.php");

//Start session and update timeout
AuthHelper::my_session_start();
if (!AuthHelper::IsAuthenticated())
{
    $_SESSION['loginError'] = "You must login to continue";
    header("Location: login.php", true, 303);
    exit();
}

$roundId = 0;

//If a new round was just scored, submit it and get the roundID
if(isset($_POST['submitRound']))
{
    $courseName = $_POST['course'];
    $roundDate = $_POST['roundDate'];
    $players = $_POST['name'];
    $scores = $_POST['score'];

    $hh = new HandicapHelper();
    $roundId = $hh->ScoreRound($courseName, $roundDate, $players, $scores);
}

//If the scoring was completed and we get the roundId, navigate to show the round.
if($roundId)
{
    header("Location: rounds.php?roundID=$roundId");
    exit();
}
// If we don't get a round back jsut go back tot he score round page.
else
{
    header("Location: score_round.php");
    exit();
}




?>