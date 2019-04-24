<?php
require_once("../upload/lib/TableMaker.php");
require_once('../upload/lib/LinkedTableMaker.php');
require_once("../upload/lib/PlayerHelper.php");
require_once("../upload/lib/HandicapHelper.php");

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

// Creates html table of Long pad handicaps
function ShowLongPadsTable()
{
    // Get table info
    $hh = new HandicapHelper();
    $handiData =  $hh->GetHandicapTableInfo(2);

    //Create "Members" Table
    $tm = new TableMaker();
    $tm->headers = ["Name", "Rd1", "Rd2", "Rd3", "Rd4", "Rd5", "Total", "100% Avg", "80% Avg", "Adj"];
    $tm->caption =     "Long Pads<span class='smallcap'><br>Click column name to sort</span>";
    $tm->tagId = "lp";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $handiData;
    echo $tm->GetTable();
}

// Creates html table of Short pad handicaps
function ShowShortPadsTable()
{
    // Get table info
    $hh = new HandicapHelper();
    $handiData =  $hh->GetHandicapTableInfo(1);

    //Create "Members" Table
    $tm = new TableMaker();
    $tm->headers = ["Name", "Rd1", "Rd2", "Rd3", "Rd4", "Rd5", "Total", "100% Avg", "80% Avg", "Adj"];
    $tm->caption =     "Long Pads<span class='smallcap'><br>Click column name to sort</span>";
    $tm->tagId = "sp";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $handiData;
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

//Creates a linked table with the last 50 rounds
function ShowRoundsList()
{
    $hh = new HandicapHelper();
    //Get list of rounds
    $roundsList = $hh->Get50Rounds(0);

    $ltm =  new LinkedTableMaker();
    $ltm->headers = ["Round Date", "Course"];
    $ltm->caption = "Recent Rounds<br><span class='smallcap'>Click to View Results</span>";
    $ltm->data = $roundsList;
    $ltm->rowLink = "rounds.php?roundID=";
    echo $ltm->GetTable();
}

function ShowRoundResults($roundId)
{
    $hh = new HandicapHelper();
    $roundData = [];
    //Get the round info from the DB and assign it if there is a roundID set
    if($roundId)
    {
        $roundData = $hh->GetHandicapRound($roundId);
    }
    if(count($roundData))
    {
        $roundInfo = $hh->GetRoundCourseAndDate($roundId);
        $caption = $roundInfo[1] ." on ". $roundInfo[0];
        $tm = new TableMaker();
        $tm->headers = ["Player","Raw Score", "Handicap", "Net Score"];
        $tm->caption = $caption;
        $tm->data = $roundData;
        echo $tm->GetTable();
    }
}
