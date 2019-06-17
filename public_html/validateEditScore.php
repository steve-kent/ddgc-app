<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require("../lib/HandicapHelper.php");
require_once("../lib/validator.php");




$roundId = 0;
// Make sure this is comming from the form
if(isset($_POST['saveChanges']))
{
    $rawScore = $_POST['rawScore'];
    $handicap = $_POST['handicap'];
    $netScore = $_POST['netScore'];
    $scoreId = $_POST['scoreId'];

    // Make sure data is valid
    if(is_numeric($rawScore) && is_numeric($handicap) && is_numeric($netScore) 
    && $netScore == $rawScore + $handicap
    && $scoreId > 0)
    {
        $hh = new HandicapHelper();        
        $roundId = $hh->UpdateScore($scoreId, $rawScore, $handicap, $netScore);
    }
}
else if (isset($_POST['deleteScore']))
{
    $scoreId = $_POST['scoreId'];
    $hh = new HandicapHelper(); 
    $roundId = $hh->DeteleScoreById($scoreId);
}

//If the edit was added and we get the roundId, navigate to show the round.
if($roundId)
{
    header("Location: rounds.php?roundId=$roundId");
    exit();
}
// If we don't get a round back show error.
else
{
    echo "There was a problem editing the score. Go back and try again";
    exit();
}

?>