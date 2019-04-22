<?php
require("../upload/models/Player.php");
require("../upload/lib/PlayerHelper.php");
require_once("../upload/lib/validator.php");
require("../upload/lib/AuthHelper.php");

//Start session and update timeout
my_session_start();
DoAuthCheck();



$playerId = 0;
// Make sure this is comming from the form
if(isset($_POST['saveChanges']))
{
    // Make sure a first and last name or nickname is entered
    if((!"" == trim($_POST['firstName']) && !"" == trim($_POST['lastName'])) ||
    !"" == trim($_POST['nickName']))
    {
        $ph = new PlayerHelper();
        $player = new Player();
        $player->playerId = $_POST['playerId'];
        $player->firstName = trim($_POST['firstName']) ?: null;
        $player->lastName = trim($_POST['lastName']) ?: null;
        $player->nickName = trim($_POST['nickName']) ?: null;
        $player->email = trim($_POST['email']) ?: null;
        $player->memberNumber =  trim($_POST['memberNumber']);
        $player->oweShirt = isset($_POST['oweShirt']) ? 1 : 0;
        $player->pdga = $_POST['pdga'] ?: null;
        if($_POST['memberRadio'] == 'isMember')
        {
            $player->memberNumber =  trim($_POST['memberNumber']) ?: $ph->GetNextMemberNumber();
            $player->expires = $_POST['expireDate'];
        }
        else
        {
            $player->expires = $_POST['expireDate'] ?: null;
        }
        $playerId = $ph->UpdatePlayer($player);
    }
}



header("Location: edit_player.php?playerId=$playerId");
exit();


?>