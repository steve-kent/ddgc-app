<?php
require("../uploads/models/Player.php");
require("../uploads/lib/PlayerHelper.php");
require_once("../upload/lib/validator.php");

$playerId = null;
// Make sure this is comming from the form
if(isset($_POST['addPlayer']))
{
    // Make sure a first and last name or nickname is entered
    if((!"" == trim($_POST['firstName']) && !"" == trim($_POST['lastName'])) ||
    !"" == trim($_POST['nickName']))
    {
        $player = new Player();
        // SET THIS!! $player->memberNumber = null;
        $player->firstName = trim($_POST['firstName']) ?: null;
        $player->lastName = trim($_POST['lastName']) ?: null;
        $player->nickName = trim($_POST['nickName']) ?: null;
        $player->email = trim($_POST['email']) ?: null;
        if($_POST['memberRadio'] == 'isMember')
        {
            $player->expires = $_POST['expireDate'];
            $player->oweShirt = $_POST['oweShirt'];
            $player->pdga = $_POST['pdga'] ? 0 : 1;
        }
        else
        {
            $player->expires = '2010-01-01';
        }
    }
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