<?php
require("page.php");
require("../upload/db/DbTalker.php");
require("../upload/lib/HandicapHelper.php");

$roundId = 0;

if(isset($_POST['submitRound']))
{
    $courseName = $_POST['course'];
    $roundDate = $_POST['roundDate'];
    $players = $_POST['name'];
    $scores = $_POST['score'];

    $hh = new HandicapHelper();
    $roundId = $hh->ScoreRound($courseName, $roundDate, $players, $scores);
}




?>