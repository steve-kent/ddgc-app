<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require("../models/Player.php");
require("../lib/PlayerHelper.php");
require_once("../lib/validator.php");

$playerId = 0;
// Make sure this is comming from the form
if(isset($_POST['addPlayer']))
{
    // Make sure a first and last name or nickname is entered
    if((!"" == trim($_POST['firstName']) && !"" == trim($_POST['lastName'])) ||
    !"" == trim($_POST['nickName']))
    {
        $ph = new PlayerHelper();
        $player = new Player();
        // SET THIS!! $player->memberNumber = null;
        $player->firstName = trim($_POST['firstName']) ?: null;
        $player->lastName = trim($_POST['lastName']) ?: null;
        $player->nickName = trim($_POST['nickName']) ?: null;
        $player->email = trim($_POST['email']) ?: null;
        if($_POST['memberRadio'] == 'isMember')
        {
            $player->memberNumber =  $ph->GetNextMemberNumber();
            $player->expires = $_POST['expireDate'];
            $player->oweShirt = isset($_POST['oweShirt']) ? 1 : 0;
            $player->pdga = $_POST['pdga'] ?: null;
        }
        else
        {
            $player->expires = '2010-01-01';
        }
        $playerId = $ph->AddPlayer($player);
    }
}

//If the player was added and we get the playerId, navigate to players and show the players info.
if($playerId)
{
    header("Location: edit_player.php?playerId=$playerId");
    exit();
}
// If we don't get a player back just go back to he add player page.
else
{
    header("Location: add_player.php");
    exit();
}

?>