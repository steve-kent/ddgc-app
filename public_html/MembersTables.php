<?php
require_once("../upload/lib/TableMaker.php");
require_once('../upload/lib/LinkedTableMaker.php');
require_once("../upload/lib/PlayerHelper.php");

// Creates html table of all members
function ShowMembersTable()
{
    // Get member's list
    $ph = new PlayerHelper();
    $players = $ph->GetMembersTableData();

    //Create "Members" Table
    $tm = new TableMaker();
    $tm->headers = ["Member#", "Name", "Expires"];
    $tm->caption =     "Members<span class='smallcap'></span>";
    $tm->tagId = "mt";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $players;
    echo $tm->GetTable();
}

//Creates html table with list of all players as links
function ShowPlayersTable()
{
    //Get an array of all player names and IDs
    $ph = new PlayerHelper();
    $playerList = $ph->GetPlayerListAndId();

    //Create the table with links
    $ltm =  new LinkedTableMaker();
    $ltm->tagId = "playerList";
    $ltm->headers = ["Player"];
    $ltm->caption = "All Players<br><span class='smallcap'>Click on a player to view/edit</span><br><input type='text' id='playerSearch' onkeyup='playerSearch()' placeholder='Search for names..'>";
    $ltm->data = $playerList;
    $ltm->rowLink = "edit_player.php?playerId=";
    echo $ltm->GetTable();
}
